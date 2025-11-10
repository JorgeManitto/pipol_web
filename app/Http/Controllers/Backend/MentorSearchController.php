<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pipol_sessions;
use App\Models\Skills;
use App\Models\User;
use App\Notifications\NuevaNotificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MentorSearchController extends Controller
{
    /**
     * Muestra el listado de mentores con filtros dinámicos
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->where('is_mentor', true)
            ->where('active', true)
            ->with('skills');

        // 🔍 Filtro: por nombre o profesión
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('name', 'like', "%{$q}%")
                         ->orWhere('last_name', 'like', "%{$q}%")
                         ->orWhere('profession', 'like', "%{$q}%")
                         ->orWhere('bio', 'like', "%{$q}%");
            });
        }

        // 🎯 Filtro: por skill
        if ($request->filled('skill')) {
            $skillId = $request->input('skill');
            $query->whereHas('skills', function ($q) use ($skillId) {
                $q->where('skills.id', $skillId);
            });
        }

        // 🌍 Filtro: país
        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        // 💰 Filtro: rango de precios
        if ($request->filled('min_rate')) {
            $query->where('hourly_rate', '>=', (float) $request->input('min_rate'));
        }
        if ($request->filled('max_rate')) {
            $query->where('hourly_rate', '<=', (float) $request->input('max_rate'));
        }

        // 🔽 Orden
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('hourly_rate', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('hourly_rate', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'recent':
            default:
                $query->latest();
        }

        // 📄 Paginación
        $mentors = $query->paginate(12)->withQueryString();

        // Todas las skills para el filtro lateral
        $skills = Skills::orderBy('name')->get();

        return view('backend.mentors.index', compact('mentors', 'skills'));
    }

    function setAppointment(Request $request) {
        // Lógica para guardar la cita en la base de datos

        $parameters = $request->all();
        
        Pipol_sessions::create([
            'mentor_id' => $parameters['mentor_id'],
            'mentee_id' => $parameters['mentee_id'],
            'scheduled_at' => Carbon::parse("{$parameters['selectedDate']} {$parameters['selectedTime']}"),
            'duration_minutes' => 60,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'price' => $parameters['hourly_rate'],
            'currency' => $parameters['currency'],
        ]);

        $this->enviarNotificacion($parameters['mentor_id'], 'Tienes una nueva solicitud de sesión de mentoría.');
        return response()->json(['message' => 'Sesión creada con exito.'], 200);
        
    }
    public function enviarNotificacion($userId = 2, $mensaje = 'HOLA! wEsta es una notificación de prueba desde MentorSearchController.')
    {
        try {
            $user = User::find($userId);
            $user->notify(new NuevaNotificacion($mensaje));
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
