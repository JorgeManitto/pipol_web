<?php
namespace App\Http\Controllers\Backend\Admin\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\TimeEntry;
use App\Services\Fraccional\ChatSystemMessenger;
use Illuminate\Http\Request;

class MediationController extends Controller
{
    public function index()
    {
        //$this->authorizeAdmin();

        $pending = TimeEntry::where('status', TimeEntry::STATUS_IN_MEDIATION)
            ->with(['contract.engagement.company', 'contract.engagement.professional'])
            ->latest('professional_responded_at')
            ->paginate(20);

        return view('backend.admin.fraccional.mediation.index', compact('pending'));
    }

    public function show(TimeEntry $entry)
    {
        //$this->authorizeAdmin();
        $entry->load(['contract.engagement.company', 'contract.engagement.professional', 'professional']);
        return view('backend.admin.fraccional.mediation.show', compact('entry'));
    }

    public function resolve(Request $request, TimeEntry $entry)
    {
        //$this->authorizeAdmin();
        abort_unless($entry->status === TimeEntry::STATUS_IN_MEDIATION, 400);

        $data = $request->validate([
            'outcome'         => 'required|in:company,professional,partial',
            'approved_hours'  => 'required_if:outcome,partial|nullable|numeric|min:0|max:'.$entry->hours,
            'mediation_notes' => 'required|string|min:10|max:2000',
        ]);

        $statusMap = [
            'company'      => TimeEntry::STATUS_RESOLVED_COMPANY,
            'professional' => TimeEntry::STATUS_RESOLVED_PROFESSIONAL,
            'partial'      => TimeEntry::STATUS_RESOLVED_PARTIAL,
        ];

        $entry->update([
            'status'                         => $statusMap[$data['outcome']],
            'mediator_id'                    => auth()->id(),
            'mediation_notes'                => $data['mediation_notes'],
            'mediation_outcome'              => $data['outcome'],
            'approved_hours_after_mediation' => $data['outcome'] === 'partial'
                ? $data['approved_hours']
                : ($data['outcome'] === 'professional' ? $entry->hours : 0),
            'mediated_at'                    => now(),
        ]);

        ChatSystemMessenger::post($entry->contract->engagement, 'mediation_resolved', [
            'entry_id'       => $entry->id,
            'outcome'        => $data['outcome'],
            'approved_hours' => $entry->approved_hours_after_mediation ?? $entry->hours,
            'total_hours'    => $entry->hours,
            'notes'          => $data['mediation_notes'],
        ]);

        return redirect()->route('admin.fraccional.mediation.index')
            ->with('success', 'Mediación resuelta.');
    }

    protected function authorizeAdmin(): void
    {
        abort_unless(auth()->user()->role === 'admin', 403);
    }
}