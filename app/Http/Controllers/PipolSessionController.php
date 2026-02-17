<?php

namespace App\Http\Controllers;

use App\Models\Pipol_sessions;
use App\Models\Reviews;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PipolSessionController extends Controller
{
    private const MENTOR_MODIFICATION_DEADLINE_HOURS = 48;

    /**
     * Mostrar lista de sesiones del usuario (mentor o mentee)
     */
    public function index()
    {
        $user = Auth::user();
        $proximas_sesiones = collect();
        $pasadas_sesiones = collect();
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
                // ->where('status', 'completed')
                ->where('scheduled_at', '<', now())
                ->with(['mentee'])
                ->orderBy('id', 'desc')
                ->get();
            $canceladas_sesiones = Pipol_sessions::where('mentee_id', $user->id)
                ->where('status', 'cancelled')
                ->with(['mentee'])
                ->orderBy('id', 'desc')
                ->get();
        }

        // Preparar datos del calendario
        $calendarData = $this->prepareCalendarData($proximas_sesiones, $pasadas_sesiones);

        return view('backend.sessions.index', compact(
            'proximas_sesiones',
            'user',
            'pasadas_sesiones',
            'canceladas_sesiones',
            'calendarData'
        ));
    }

    /**
     * Preparar datos del calendario con las sesiones
     */
    private function prepareCalendarData($proximas_sesiones, $pasadas_sesiones)
    {
        $allSessions = $proximas_sesiones->concat($pasadas_sesiones);

        // Agrupar sesiones por fecha
        $sessionsByDate = [];
        foreach ($allSessions as $session) {
            $date = Carbon::parse($session->scheduled_at)->format('Y-m-d');
            if (!isset($sessionsByDate[$date])) {
                $sessionsByDate[$date] = [];
            }
            $sessionsByDate[$date][] = [
                'id' => $session->id,
                'time' => Carbon::parse($session->scheduled_at)->format('H:i'),
                'status' => $session->status,
                'is_upcoming' => Carbon::parse($session->scheduled_at)->isFuture(),
            ];
        }

        return [
            'sessionsByDate' => $sessionsByDate,
            'currentMonth' => now()->month,
            'currentYear' => now()->year,
            'today' => now()->format('Y-m-d'),
        ];
    }

    /**
     * Mostrar detalle de una sesión
     */
    public function show($id)
    {
        $session = Pipol_sessions::with(['mentor', 'mentee', 'review'])->findOrFail($id);
        $user = Auth::user();

        // Verificar que el usuario tiene permiso para ver la sesión
        if ($session->mentor_id !== $user->id && $session->mentee_id !== $user->id) {
            abort(403, 'No tienes permiso para ver esta sesión.');
        }

        return view('backend.sessions.show', compact('session'));
    }

    /**
     * Confirmar una sesión (mentor la acepta)
     */
    public function confirm($id)
    {
        $session = Pipol_sessions::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $session->mentor_id) {
            abort(403, 'Solo el mentor puede confirmar la sesión.');
        }

        $session->status = 'confirmed';
        $session->mentor_confirmed = true;
        $session->save();

        return back()->with('success', 'Sesión confirmada correctamente.');
    }

    public function confirmJson()
    {
        $id = request()->input('id');
        $session = Pipol_sessions::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $session->mentor_id) {
            return response()->json(['status' => 'Solo el mentor puede confirmar la sesión.'], 403);
        }

        $session->status = 'confirmed';
        $session->mentor_confirmed = true;
        $session->save();

        return response()->json(['status' => 'Sesión confirmada correctamente.']);
    }

    /**
     * Marcar una sesión como completada (mentee o mentor)
     */
    public function complete($id)
    {
        $session = Pipol_sessions::findOrFail($id);
        $user = Auth::user();

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

        // Si ambos confirmaron, la sesión se marca como completada
        if ($session->mentor_confirmed && $session->mentee_confirmed) {
            $session->status = 'completed';
            $session->completed_at = now();
        }

        $session->save();

        return back()->with('success', 'Sesión marcada como completada.');
    }

    /**
     * Cancelar una sesión
     */
    public function cancel(Request $request)
    {
        $id = $request->input('id');
        $session = Pipol_sessions::findOrFail($id);
        $user = Auth::user();

        if ($session->status === 'completed') {
            return response()->json(['status' => 'No se puede cancelar una sesión completada.'], 422);
        }

        if ($user->id !== $session->mentor_id && $user->id !== $session->mentee_id) {
            abort(403);
        }

        if ($user->id === $session->mentor_id && !$this->mentorCanModifySession($session)) {
            return response()->json([
                'status' => 'Como mentor, solo puedes cancelar la sesión con al menos 48 horas de anticipación.'
            ], 422);
        }

        $session->status = 'cancelled';
        $session->save();

        $transaction = Transaction::where('session_id', $session->id)->first();
        if ($transaction && $transaction->status === 'paid') {
            // Lógica para reembolsar el pago al mentee
            $transaction->status = 'refunded';
            $transaction->refunded_at = now();
            $transaction->notes = 'Reembolso automático por cancelación de sesión.';
            $transaction->save();
        }

        return response()->json(['status' => 'Sesión cancelada correctamente.']);
    }

    /**
     * Reprogramar una sesión
     */
    public function reschedule(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:pipol_sessions,id',
            'scheduled_at' => 'required|date|after:now',
        ], [
            'scheduled_at.after' => 'La nueva fecha y hora debe ser futura.',
        ]);

        $session = Pipol_sessions::findOrFail($validated['id']);
        $user = Auth::user();

        if ($user->id !== $session->mentor_id) {
            return response()->json(['status' => 'Solo el mentor puede reprogramar la sesión.'], 403);
        }

        if (in_array($session->status, ['cancelled', 'completed'])) {
            return response()->json(['status' => 'No se puede reprogramar una sesión cancelada o completada.'], 422);
        }

        if (!$this->mentorCanModifySession($session)) {
            return response()->json([
                'status' => 'Como mentor, solo puedes reprogramar la sesión con al menos 48 horas de anticipación.'
            ], 422);
        }

        $session->scheduled_at = Carbon::parse($validated['scheduled_at']);
        $session->save();

        return response()->json(['status' => 'Sesión reprogramada correctamente.']);
    }

    private function mentorCanModifySession(Pipol_sessions $session): bool
    {
        return Carbon::parse($session->scheduled_at)->greaterThanOrEqualTo(
            now()->addHours(self::MENTOR_MODIFICATION_DEADLINE_HOURS)
        );
    }

    /**
     * Guardar valoración después de una sesión completada
     */
    public function review(Request $request)
    {
        $session = Pipol_sessions::findOrFail($request->session_id);
        $user = Auth::user();

        if ($session->mentee_id !== $user->id) {
            return response()->json(['status' => 'Solo el mentee puede valorar la sesión.'], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'La calificación es obligatoria.',
            'rating.min' => 'La calificación mínima es 1.',
            'rating.max' => 'La calificación máxima es 5.',
            'comment.string' => 'El comentario debe ser una cadena de texto.',
            'comment.max' => 'El comentario no puede exceder los 1000 caracteres.',
        ]);

        Reviews::updateOrCreate(
            ['session_id' => $session->id, 'mentee_id' => $user->id],
            [
                'mentor_id' => $session->mentor_id,
                'rating' => intval($validated['rating']),
                'comment' => $validated['comment'] ?? null,
            ]
        );
        $session->status = 'completed';
        $session->completed_at = now();
        $session->save();

        return response()->json(['status' => 'Valoración guardada correctamente.'], 200);
    }
}
