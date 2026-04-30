<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FraccionalController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', User::ROLE_FRACCIONAL_PROFESSIONAL)
        ->where('active', true)
        ->with(['reviewsReceived']);

        if ($request->filled('seniority')) {
            $query->where('seniority', $request->seniority);
        }

        if ($request->filled('disponibilidad')) {
            if ($request->disponibilidad === 'inmediato') {
                $query->where('workingNow', false);
            }
        }

        if ($request->filled('precio_min')) {
            $query->where('hourly_rate', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('hourly_rate', '<=', $request->precio_max);
        }

        $profesionales = $query->orderByDesc('average_rating')->paginate(12);

        return view('backend.fraccional.index', compact('profesionales'));
    }
    public function show(User $user)
    {
        abort_unless($user->isFraccionalProfessional(), 404);
        $user->load(['reviewsReceived.mentee']);
        $user->increment('view_count');
        return view('backend.fraccional.show', compact('user'));
    }
    function nuevoDiagnostico() {
        
        return view('backend.fraccional.nuevo-diagnostico');
    }
}
