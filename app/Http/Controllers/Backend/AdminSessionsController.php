<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pipol_sessions;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSessionsController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'is_admin']);
    }

    /* ──────────────────────────────────────────────────────
     |  INDEX — sesiones confirmed y próximas
     ─────────────────────────────────────────────────────── */
    public function index(Request $request)
    {
        $query = Pipol_sessions::where('status', 'confirmed')
            ->where('scheduled_at', '>=', now())
            ->with(['mentor', 'mentee'])
            ->orderBy('scheduled_at', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('mentor', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('mentee', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        $sessions = $query->paginate(20)->withQueryString();

        $stats = [
            'total'    => Pipol_sessions::where('status', 'confirmed')->where('scheduled_at', '>=', now())->count(),
            'sin_meet' => Pipol_sessions::where('status', 'confirmed')->where('scheduled_at', '>=', now())->whereNull('meet_link')->count(),
            'con_meet' => Pipol_sessions::where('status', 'confirmed')->where('scheduled_at', '>=', now())->whereNotNull('meet_link')->count(),
        ];

        return view('backend.admin.sessions.index', compact('sessions', 'stats'));
    }

    /* ──────────────────────────────────────────────────────
     |  SHOW
     ─────────────────────────────────────────────────────── */
    public function show(Pipol_sessions $session)
    {
        $session->load(['mentor', 'mentee']);
        return view('backend.admin.sessions.show', compact('session'));
    }

    /* ──────────────────────────────────────────────────────
     |  GENERAR MEET
     ─────────────────────────────────────────────────────── */
    public function generateMeet(Request $request, Pipol_sessions $session)
    {
        if ($session->meet_link) {
            return response()->json([
                'success'   => false,
                'message'   => 'Esta sesión ya tiene un enlace de Meet asignado.',
                'meet_link' => $session->meet_link,
            ], 422);
        }

        $session->load(['mentor', 'mentee']);

        $start = $session->scheduled_at;
        $end   = $session->scheduled_at->copy()->addMinutes($session->duration_minutes);

        $attendees = [];
        if ($session->mentee?->email) $attendees[] = $session->mentee->email;
        if ($session->mentor?->email) $attendees[] = $session->mentor->email;

        try {
            $meetLink = app(\App\Services\GoogleMeetService::class)
                ->createMeet(
                    "Sesión de mentoría - {$session->mentor->name}",
                    $start,
                    $end,
                    $attendees
                );

            $session->update(['meet_link' => $meetLink]);

            return response()->json([
                'success'   => true,
                'meet_link' => $meetLink,
                'message'   => 'Enlace de Meet generado correctamente.',
            ]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el enlace de Meet: ' . $e->getMessage(),
            ], 500);
        }
    }
}