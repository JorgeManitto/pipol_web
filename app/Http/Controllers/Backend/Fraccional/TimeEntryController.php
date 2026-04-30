<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\{Contract, TimeEntry};
use App\Services\Fraccional\ChatSystemMessenger;
use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    public function store(Request $request, Contract $contract)
    {
        abort_unless($contract->engagement->professional_id === auth()->id(), 403);
        abort_unless($contract->engagement->status === 'active', 400,
            'Solo podés cargar horas con el servicio activo.');

        $data = $request->validate([
            'worked_on'   => 'required|date|before_or_equal:today',
            'hours'       => 'required|numeric|min:0.25|max:24',
            'description' => 'required|string|max:500',
        ]);

        $entry = TimeEntry::create([
            ...$data,
            'contract_id'        => $contract->id,
            'professional_id'    => auth()->id(),
            'status'             => TimeEntry::STATUS_PENDING,
            'review_deadline_at' => now()->addHours(72),
        ]);

        ChatSystemMessenger::post($contract->engagement, 'time_entry_added', [
            'entry_id'          => $entry->id,
            'hours'             => $entry->hours,
            'worked_on'         => $entry->worked_on->format('d/m/Y'),
            'professional_name' => auth()->user()->name,
        ]);

        return back()->with('success', 'Horas cargadas. La empresa tiene 72hs para aprobarlas.');
    }

    public function approve(TimeEntry $entry)
    {
        $contract = $entry->contract;
        abort_unless($contract->engagement->company_id === auth()->id(), 403);
        abort_unless($entry->isPending(), 400, 'Esta entrada ya fue revisada.');

        $entry->update([
            'status'      => TimeEntry::STATUS_APPROVED,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        ChatSystemMessenger::post($contract->engagement, 'time_entry_approved', [
            'entry_id'  => $entry->id,
            'hours'     => $entry->hours,
            'worked_on' => $entry->worked_on->format('d/m/Y'),
        ]);

        return back()->with('success', 'Horas aprobadas.');
    }

    public function dispute(Request $request, TimeEntry $entry)
    {
        $contract = $entry->contract;
        abort_unless($contract->engagement->company_id === auth()->id(), 403);
        abort_unless($entry->isPending(), 400, 'Esta entrada ya fue revisada.');

        $data = $request->validate([
            'dispute_reason' => 'required|string|min:10|max:1000',
        ]);

        $entry->update([
            'status'         => TimeEntry::STATUS_DISPUTED,
            'reviewed_at'    => now(),
            'reviewed_by'    => auth()->id(),
            'dispute_reason' => $data['dispute_reason'],
            'disputed_at'    => now(),
        ]);

        ChatSystemMessenger::post($contract->engagement, 'time_entry_disputed', [
            'entry_id'  => $entry->id,
            'hours'     => $entry->hours,
            'worked_on' => $entry->worked_on->format('d/m/Y'),
            'reason'    => $data['dispute_reason'],
        ]);

        // \Notification::route('mail', config('fraccional.admin_email'))
        //     ->notify(new TimeEntryDisputed($entry));

        return back()->with('info', 'Reclamo iniciado. Te contactaremos para mediar.');
    }

    public function destroy(TimeEntry $entry)
    {
        abort_unless($entry->professional_id === auth()->id(), 403);

        // Solo permitir borrar si está pendiente y dentro de 24hs de creación
        abort_unless($entry->isPending(), 400,
            'No podés borrar entradas ya revisadas. Hablalo por chat con la empresa.');
        abort_if($entry->created_at->lt(now()->subHours(24)), 400,
            'Solo podés borrar entradas creadas en las últimas 24hs.');

        $entry->delete();
        return back()->with('success', 'Entrada eliminada.');
    }
}