<?php

namespace App\Http\Controllers;

use App\Models\Pipol_sessions;
use App\Models\Reviews;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PipolSessionController extends Controller
{
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
        
        
        return view('backend.sessions.index', compact('proximas_sesiones', 'user', 'pasadas_sesiones', 'canceladas_sesiones'));
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
        // dd($session);
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
        // dd($session);
        $user = Auth::user();

        if ($session->status === 'completed') {
            return back()->with('error', 'No se puede cancelar una sesión completada.');
        }

        if ($user->id !== $session->mentor_id && $user->id !== $session->mentee_id) {
            abort(403);
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
        // return back()->with('success', 'Sesión cancelada correctamente.');
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

        // if ($session->status !== 'completed') {
        //     return response()->json(['status' => 'Solo se pueden valorar sesiones completadas.'], 403);
        // }

        // $validated = $request->validate([
        //     'rating' => 'required|integer|min:1|max:5',
        //     'comment' => 'nullable|string|max:1000',
        // ]);
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
