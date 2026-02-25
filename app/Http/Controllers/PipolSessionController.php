<?php

namespace App\Http\Controllers;

use App\Models\Pipol_sessions;
use App\Models\Reviews;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NuevaNotificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PipolSessionController extends Controller
{
    private const MENTOR_MODIFICATION_DEADLINE_HOURS = 48;

    /* ──────────────────────────────────────────────────────
     |  INDEX
     ─────────────────────────────────────────────────────── */

    public function index()
    {
        $user                = Auth::user();
        $proximas_sesiones   = collect();
        $pasadas_sesiones    = collect();
        $canceladas_sesiones = collect();

        if ($user->is_mentor) {
            $proximas_sesiones = Pipol_sessions::where('mentor_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->where('scheduled_at', '>=', now())
                ->with(['mentee'])
                ->orderBy('id', 'desc')
                ->get();

            $pasadas_sesiones = Pipol_sessions::where('mentor_id', $user->id)
                ->where('scheduled_at', '<', now())
                ->with(['mentee'])
                ->orderBy('id', 'desc')
                ->get();

            $canceladas_sesiones = Pipol_sessions::where('mentor_id', $user->id)
                ->where('status', 'cancelled')
                ->with(['mentee'])
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $proximas_sesiones = Pipol_sessions::where('mentee_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->where('scheduled_at', '>=', now())
                ->with(['mentor'])
                ->orderBy('id', 'desc')
                ->get();

            $pasadas_sesiones = Pipol_sessions::where('mentee_id', $user->id)
                ->where('scheduled_at', '<', now())
                ->with(['mentor'])
                ->orderBy('id', 'desc')
                ->get();

            $canceladas_sesiones = Pipol_sessions::where('mentee_id', $user->id)
                ->where('status', 'cancelled')
                ->with(['mentor'])
                ->orderBy('id', 'desc')
                ->get();
        }

        $calendarData = $this->prepareCalendarData($proximas_sesiones, $pasadas_sesiones);

        return view('backend.sessions.index', compact(
            'proximas_sesiones',
            'user',
            'pasadas_sesiones',
            'canceladas_sesiones',
            'calendarData'
        ));
    }

    /* ──────────────────────────────────────────────────────
     |  SHOW
     ─────────────────────────────────────────────────────── */

    public function show($id)
    {
        $session = Pipol_sessions::with(['mentor', 'mentee', 'review'])->findOrFail($id);
        $user    = Auth::user();

        if ($session->mentor_id !== $user->id && $session->mentee_id !== $user->id) {
            abort(403, 'No tienes permiso para ver esta sesión.');
        }

        return view('backend.sessions.show', compact('session'));
    }

    /* ──────────────────────────────────────────────────────
     |  CONFIRM  (mentor acepta la sesión)
     ─────────────────────────────────────────────────────── */

    public function confirm($id)
    {
        $session = Pipol_sessions::findOrFail($id);
        $user    = Auth::user();

        if ($user->id !== $session->mentor_id) {
            abort(403, 'Solo el mentor puede confirmar la sesión.');
        }

        $session->status           = 'confirmed';
        $session->mentor_confirmed = true;
        $session->save();

        // Notificar al mentee que su sesión fue confirmada
        $this->enviarNotificacion(
            $session->mentee_id,
            'Tu sesión de mentoría ha sido confirmada.',
            route('sessions.index')
        );

        return back()->with('success', 'Sesión confirmada correctamente.');
    }

    public function confirmJson()
    {
        $id      = request()->input('id');
        $session = Pipol_sessions::findOrFail($id);
        $user    = Auth::user();

        if ($user->id !== $session->mentor_id) {
            return response()->json(['status' => 'Solo el mentor puede confirmar la sesión.'], 403);
        }

        $session->status           = 'confirmed';
        $session->mentor_confirmed = true;
        $session->save();

        // Notificar al mentee que su sesión fue confirmada
        $this->enviarNotificacion(
            $session->mentee_id,
            'Tu sesión de mentoría ha sido confirmada.',
            route('sessions.index')
        );

        return response()->json(['status' => 'Sesión confirmada correctamente.']);
    }

    /* ──────────────────────────────────────────────────────
     |  COMPLETE
     ─────────────────────────────────────────────────────── */

    public function complete($id)
    {
        $session = Pipol_sessions::findOrFail($id);
        $user    = Auth::user();

        if ($session->status !== 'confirmed') {
            return back()->with('error', 'Solo se pueden completar sesiones confirmadas.');
        }

        if ($user->id === $session->mentor_id) {
            $session->mentor_confirmed = true;
        } elseif ($user->id === $session->mentee_id) {
            $session->mentee_confirmed = true;
        } else {
            abort(403);
        }

        if ($session->mentor_confirmed && $session->mentee_confirmed) {
            $session->status       = 'completed';
            $session->completed_at = now();
        }

        $session->save();

        return back()->with('success', 'Sesión marcada como completada.');
    }

    /* ──────────────────────────────────────────────────────
     |  CANCEL
     ─────────────────────────────────────────────────────── */

    public function cancel(Request $request)
    {
        $id      = $request->input('id');
        $session = Pipol_sessions::findOrFail($id);
        $user    = Auth::user();

        if ($session->status === 'completed') {
            return response()->json(['status' => 'No se puede cancelar una sesión completada.'], 422);
        }

        if ($user->id !== $session->mentor_id && $user->id !== $session->mentee_id) {
            abort(403);
        }

        // El mentor solo puede cancelar con ≥48 h de antelación
        if ($user->id === $session->mentor_id && ! $session->isModifiableByMentor()) {
            return response()->json([
                'status' => 'Como mentor, solo puedes cancelar la sesión con al menos 48 horas de anticipación.'
            ], 422);
        }

        $session->status             = 'cancelled';
        $session->reschedule_pending = false;
        $session->save();

        $transaction = Transaction::where('session_id', $session->id)->first();
        if ($transaction && $transaction->status === 'paid') {
            $transaction->status      = 'refunded';
            $transaction->refunded_at = now();
            $transaction->notes       = 'Reembolso automático por cancelación de sesión.';
            $transaction->save();
        }

        // Notificar a la otra parte sobre la cancelación
        $esMentor       = $user->id === $session->mentor_id;
        $destinatarioId = $esMentor ? $session->mentee_id : $session->mentor_id;
        $quienCancela   = $esMentor ? 'El mentor' : 'El mentee';

        $this->enviarNotificacion(
            $destinatarioId,
            "{$quienCancela} ha cancelado la sesión de mentoría programada.",
            route('sessions.index')
        );

        return response()->json(['status' => 'Sesión cancelada correctamente.']);
    }

    /* ──────────────────────────────────────────────────────
     |  RESCHEDULE  (mentor propone nueva fecha)
     ─────────────────────────────────────────────────────── */

    public function reschedule(Request $request)
    {
        $validated = $request->validate([
            'id'           => 'required|integer|exists:pipol_sessions,id',
            'scheduled_at' => 'required|date|after:now',
        ], [
            'scheduled_at.after' => 'La nueva fecha y hora debe ser futura.',
        ]);

        $session = Pipol_sessions::findOrFail($validated['id']);
        $user    = Auth::user();

        if ($user->id !== $session->mentor_id) {
            return response()->json(['status' => 'Solo el mentor puede reprogramar la sesión.'], 403);
        }

        if (in_array($session->status, ['cancelled', 'completed'])) {
            return response()->json(['status' => 'No se puede reprogramar una sesión cancelada o completada.'], 422);
        }

        if (! $session->isModifiableByMentor()) {
            return response()->json([
                'status' => 'Solo puedes reprogramar la sesión con al menos 48 horas de anticipación.'
            ], 422);
        }

        if (! $session->reschedule_pending) {
            $session->original_scheduled_at = $session->scheduled_at;
        }

        $nuevaFecha                  = Carbon::parse($validated['scheduled_at']);
        $session->scheduled_at       = $nuevaFecha;
        $session->reschedule_pending = true;
        $session->save();

        // Notificar al mentee para que acepte o rechace el nuevo horario
        $this->enviarNotificacion(
            $session->mentee_id,
            'El mentor ha propuesto un nuevo horario para tu sesión. Por favor, revísalo y acéptalo o recházalo.',
            route('sessions.index')
        );

        return response()->json(['status' => 'Sesión reprogramada. El mentee debe aceptar el nuevo horario.']);
    }

    /* ──────────────────────────────────────────────────────
     |  APPROVE RESCHEDULE  (mentee acepta la nueva fecha)
     ─────────────────────────────────────────────────────── */

    public function approveReschedule(Request $request)
    {
        $session = Pipol_sessions::findOrFail($request->input('id'));
        $user    = Auth::user();

        if ($user->id !== $session->mentee_id) {
            return response()->json(['status' => 'Solo el mentee puede aceptar el cambio de horario.'], 403);
        }

        if (! $session->reschedule_pending) {
            return response()->json(['status' => 'No hay ningún cambio de horario pendiente.'], 422);
        }

        $session->reschedule_pending    = false;
        $session->original_scheduled_at = null;
        $session->save();

        // Notificar al mentor que el mentee aceptó el nuevo horario
        $this->enviarNotificacion(
            $session->mentor_id,
            'El mentee ha aceptado el nuevo horario de la sesión.',
            route('sessions.index')
        );

        return response()->json(['status' => 'Nuevo horario aceptado correctamente.']);
    }

    /* ──────────────────────────────────────────────────────
     |  REJECT RESCHEDULE  (mentee rechaza → cancela sesión)
     ─────────────────────────────────────────────────────── */

    public function rejectReschedule(Request $request)
    {
        $session = Pipol_sessions::findOrFail($request->input('id'));
        $user    = Auth::user();

        if ($user->id !== $session->mentee_id) {
            return response()->json(['status' => 'Solo el mentee puede rechazar el cambio de horario.'], 403);
        }

        if (! $session->reschedule_pending) {
            return response()->json(['status' => 'No hay ningún cambio de horario pendiente.'], 422);
        }

        $session->status             = 'cancelled';
        $session->reschedule_pending = false;
        $session->save();

        $transaction = Transaction::where('session_id', $session->id)->first();
        if ($transaction && $transaction->status === 'paid') {
            $transaction->status      = 'refunded';
            $transaction->refunded_at = now();
            $transaction->notes       = 'Reembolso por rechazo del mentee al cambio de horario.';
            $transaction->save();
        }

        // Notificar al mentor que el mentee rechazó el cambio y la sesión fue cancelada
        $this->enviarNotificacion(
            $session->mentor_id,
            'El mentee ha rechazado el nuevo horario. La sesión ha sido cancelada.',
            route('sessions.index')
        );

        return response()->json(['status' => 'Cambio de horario rechazado. La sesión ha sido cancelada y se procesará el reembolso.']);
    }

    /* ──────────────────────────────────────────────────────
     |  REVIEW
     ─────────────────────────────────────────────────────── */

    public function review(Request $request)
    {
        $session = Pipol_sessions::findOrFail($request->session_id);
        $user    = Auth::user();

        if ($session->mentee_id !== $user->id) {
            return response()->json(['status' => 'Solo el mentee puede valorar la sesión.'], 403);
        }

        $validated = $request->validate([
            'rating'  => 'required|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Reviews::updateOrCreate(
            ['session_id' => $session->id, 'mentee_id' => $user->id],
            [
                'mentor_id' => $session->mentor_id,
                'rating'    => intval($validated['rating']),
                'comment'   => $validated['comment'] ?? null,
            ]
        );

        $session->status       = 'completed';
        $session->completed_at = now();
        $session->save();

        // Notificar al mentor que recibió una nueva reseña
        $this->enviarNotificacion(
            $session->mentor_id,
            'Has recibido una nueva valoración de tu sesión de mentoría.',
            route('profile.show', ['id' => $session->mentor_id])."#review" // Redirige al perfil del mentor para ver la reseña
        );

        return response()->json(['status' => 'Valoración guardada correctamente.'], 200);
    }

    /* ──────────────────────────────────────────────────────
     |  PRIVATE HELPERS
     ─────────────────────────────────────────────────────── */

    private function prepareCalendarData($proximas_sesiones, $pasadas_sesiones): array
    {
        $allSessions    = $proximas_sesiones->concat($pasadas_sesiones);
        $sessionsByDate = [];

        foreach ($allSessions as $session) {
            $date = Carbon::parse($session->scheduled_at)->format('Y-m-d');
            $sessionsByDate[$date][] = [
                'id'          => $session->id,
                'time'        => Carbon::parse($session->scheduled_at)->format('H:i'),
                'status'      => $session->status,
                'is_upcoming' => Carbon::parse($session->scheduled_at)->isFuture(),
            ];
        }

        return [
            'sessionsByDate' => $sessionsByDate,
            'currentMonth'   => now()->month,
            'currentYear'    => now()->year,
            'today'          => now()->format('Y-m-d'),
        ];
    }

    /**
     * Enviar notificación a un usuario.
     */
    private function enviarNotificacion(int $userId, string $mensaje, ?string $url = null): void
    {
        try {
            $user = User::findOrFail($userId);
            $user->notify(new NuevaNotificacion($mensaje, $url));
        } catch (\Throwable $th) {
            // No interrumpir el flujo principal si la notificación falla
            report($th);
        }
    }

    function generateReunionGoogle(Request $request)
    {
        $session = Pipol_sessions::with(['mentor', 'mentee'])->findOrFail($request->session_id);

        // Calculamos inicio y fin con la duración real de la sesión
        $start = $session->scheduled_at;
        $end   = $session->scheduled_at->copy()->addMinutes($session->duration_minutes);

        $attendees = [];

        // Invitamos al mentee si tiene email
        if ($session->mentee && $session->mentee->email) {
            $attendees[] = $session->mentee->email;
        }

        $meetLink = app(\App\Services\GoogleMeetService::class)
            ->createMeet(
                "Sesión de mentoría - {$session->mentor->name}",
                $start,
                $end,
                $attendees
            );

        // Opcional: guardá el link en la sesión para no regenerarlo
        $session->update(['meet_link' => $meetLink]);

        return response()->json([
            'success' => true,
            'meet_link' => $meetLink,
        ]);
    }
}