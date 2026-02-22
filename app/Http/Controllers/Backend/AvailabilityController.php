<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Availabilitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'day_of_week'  => 'required|integer|between:0,6',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'is_recurring' => 'required|boolean',
            'active'       => 'required|boolean',
            'start_date'   => 'nullable|date|required_if:is_recurring,0',
            'end_date'     => 'nullable|date|after_or_equal:start_date|required_if:is_recurring,0',
        ]);

        $validated['mentor_id'] = Auth::id();

        Availabilitie::create($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Horario agregado correctamente.');
    }

    public function update(Request $request, Availabilitie $availability)
    {
        // Solo el dueño puede editar
        abort_if($availability->mentor_id !== Auth::id(), 403);

        $validated = $request->validate([
            'day_of_week'  => 'required|integer|between:0,6',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'is_recurring' => 'required|boolean',
            'active'       => 'required|boolean',
            'start_date'   => 'nullable|date|required_if:is_recurring,0',
            'end_date'     => 'nullable|date|after_or_equal:start_date|required_if:is_recurring,0',
        ]);

        $availability->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(Availabilitie $availability)
    {
        abort_if($availability->mentor_id !== Auth::id(), 403);

        $availability->delete();

        return redirect()->route('profile.edit')
            ->with('success', 'Horario eliminado.');
    }
}