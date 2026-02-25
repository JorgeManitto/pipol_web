<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Availabilitie;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    function index() {
        $user = auth()->user();
        $availabilities = $user->availabilities()->get();
        return view('backend.agenda.index', compact('user', 'availabilities'));
    }

    function updateHorarios(Request $request) {
        $availabilities = $request->input('availabilities');

        if(!$availabilities){
            return;
        }
        $dataavailability = $this->cleanAiJson($availabilities);
        $data = $this->extractJson($dataavailability);

        $availabilities = Availabilitie::where('mentor_id', auth()->id())->get();
        if ($availabilities->count() > 0) {
            // Si ya existen disponibilidades, las eliminamos antes de agregar las nuevas
            Availabilitie::where('mentor_id', auth()->id())->delete();
        }
        foreach ($data as $slot) {
            Availabilitie::create([
                'mentor_id'   => auth()->id(),
                'day_of_week' => $slot['day_of_week'],
                'start_time'  => $slot['start_time'],
                'end_time'    => $slot['end_time'],
                'start_date'  => $slot['start_date'],
                'end_date'    => $slot['end_date'],
                'is_recurring'=> $slot['is_recurring'],
                'active'      => true,
            ]);
        }

        return redirect()->route('agenda.index')->with('success', 'Horarios actualizados correctamente');
    }

    public function cleanAiJson(string $response): string
    {
        // Eliminar comillas triples
        $response = trim($response, "\" \n");

        // Eliminar bloques ```json y ```
        $response = preg_replace('/```json|```/i', '', $response);

        return trim($response);
    }
    function extractJson(string $text): ?array
    {
        if (preg_match('/\[[\s\S]*\]/', $text, $matches)) {
            return json_decode($matches[0], true);
        }

        return null;
    }
}
