<?php

namespace App\Http\Controllers;

use App\Models\Pipol_sessions;
use App\Models\Reviews;
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


        // dd($user);
        if ($user->is_mentor) {
            $sessions = Pipol_sessions::where('mentor_id', $user->id)
                ->with(['mentee'])
                ->orderBy('scheduled_at', 'desc')
                ->paginate(10);
        } else {
            $sessions = Pipol_sessions::where('mentee_id', $user->id)
                ->with(['mentor'])
                ->orderBy('scheduled_at', 'desc')
                ->paginate(10);
        }
        // dd($sessions);
        // dd($sessions[0]->mentor);
        return view('backend.sessions.index', compact('sessions', 'user'));
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
    public function cancel($id)
    {
        $session = Pipol_sessions::findOrFail($id);
        $user = Auth::user();

        if ($session->status === 'completed') {
            return back()->with('error', 'No se puede cancelar una sesión completada.');
        }

        if ($user->id !== $session->mentor_id && $user->id !== $session->mentee_id) {
            abort(403);
        }

        $session->status = 'cancelled';
        $session->save();

        return back()->with('success', 'Sesión cancelada correctamente.');
    }

    /**
     * Guardar valoración después de una sesión completada
     */
    public function review(Request $request, $id)
    {
        $session = Pipol_sessions::findOrFail($id);
        $user = Auth::user();

        if ($session->mentee_id !== $user->id) {
            abort(403, 'Solo el mentee puede valorar la sesión.');
        }

        if ($session->status !== 'completed') {
            return back()->with('error', 'Solo se pueden valorar sesiones completadas.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Reviews::updateOrCreate(
            ['session_id' => $session->id, 'mentee_id' => $user->id],
            [
                'mentor_id' => $session->mentor_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return back()->with('success', 'Gracias por valorar la sesión.');
    }
}
