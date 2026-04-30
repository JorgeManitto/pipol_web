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
        // $sectors = User::pluck('sectors')
        //     ->flatMap(fn ($s) => array_map('trim', explode(',', $s)))
        //     ->map(fn ($s) => mb_strtolower($s))
        //     ->unique()
        //     ->map(fn ($s) => mb_convert_case($s, MB_CASE_TITLE))
        //     ->values();

        $query = User::query()
        ->where('is_mentor', true)
        ->where('active', true)
        ->when(auth()->check(), fn ($q) => $q->where('id', '!=', auth()->id()))
        ->with('skills')
        ->withCount('sessionsAsMentor');

        if ($request->filled('params')) {
            $params = $request->input('params'); // array

            $query->where(function ($qBuilder) use ($params) {
                foreach ($params as $param) {
                    $qBuilder->orWhere('skills', 'like', "%{$param}%");
                }
            });
        }
 

        // 🔍 Filtro: por nombre o profesión
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('name', 'like', "%{$q}%");
                        //  ->orWhere('last_name', 'like', "%{$q}%")
                        //  ->orWhere('profession', 'like', "%{$q}%")
                        //  ->orWhere('bio', 'like', "%{$q}%");
            });
        }
        if ($request->filled('seniority')) {
            $query->where('seniority', $request->input('seniority'));
        }
        if ($request->filled('price')) {
            $query->orderBy('hourly_rate', $request->input('price'));
        }else{
            $query->latest();
        }

        if ($request->filled('stars')) {
            $query->whereHas('reviewsReceived', function ($q) use ($request) {
                $q->where('rating', '>=', $request->stars);
            });
        }

        // 🎯 Filtro: por skill
        if ($request->filled('skill')) {
            $skillId = $request->input('skill');
            $query->whereHas('skills', function ($q) use ($skillId) {
                $q->where('skills.id', $skillId);
            });
        }

        $rangos = [
            'BRONZE'   => 0,
            'SILVER'   => 5,
            'GOLD'     => 10,
            'PLATINUM' => 20,
            'HERO'     => 30,
            'GOD'     => 50,
        ];
        if ($request->filled('lvl')) {
            $niveles = array_keys($rangos);
            $nivel = $request->lvl;
            $index = array_search($nivel, $niveles);

            $min = $rangos[$nivel];
            $max = $rangos[$niveles[$index + 1]] ?? null;

            // dd($min, $max);
            $query->having('sessions_as_mentor_count', '>=', $min);

            if ($max !== null) {
                $query->having('sessions_as_mentor_count', '<', $max);
            }
        }



        // 📄 Paginación
        $mentors = $query->with([
            'availabilities' => function($query) {
                $query->where('active', 1);
            },
            'sessionsAsMentor' => function($query) {
                $query->where('status', 'confirmed')
                    ->where('scheduled_at', '>=', now())
                    ->select('id', 'mentor_id', 'scheduled_at', 'duration_minutes');
            }
        ])->paginate(12)->withQueryString();
        // Todas las skills para el filtro lateral
        $skills = Skills::orderBy('name')->get();

        return view('backend.mentors.index', compact('mentors', 'skills'));
    }

    function setAppointment(Request $request) {
        // Lógica para guardar la cita en la base de datos

        $parameters = $request->all();
        
        $session = Pipol_sessions::create([
            'mentor_id' => $parameters['mentor_id'],
            'mentee_id' => $parameters['mentee_id'],
            'scheduled_at' => Carbon::parse("{$parameters['selectedDate']} {$parameters['selectedTime']}"),
            'duration_minutes' => 60,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'price' => $parameters['hourly_rate'],
            'currency' => $parameters['currency'],
        ]);

        $this->enviarNotificacion($parameters['mentor_id'], 'Tienes una nueva solicitud de sesión de mentoría.', route('sessions.index'));
        return response()->json(['message' => 'Sesión creada con exito.', 'session_id' => $session->id], 200);
        
    }
    public function enviarNotificacion($userId = 2, $mensaje = 'HOLA! wEsta es una notificación de prueba desde MentorSearchController.', $url = null)
    {
        try {
            $user = User::find($userId);
            $user->notify(new NuevaNotificacion($mensaje, $url));
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    public function countViewProfile(Request $request) {
        $mentorId = $request->input('mentor_id');
        $mentor = User::find($mentorId);
        if ($mentor) {
            $mentor->increment('view_count');
            return response()->json(['message' => 'Vista de perfil contada.'], 200);
        } else {
            return response()->json(['message' => 'Mentor no encontrado.'], 404);
        }
    }
}
