<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\TimeEntry;
use App\Services\Fraccional\ChatSystemMessenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisputeController extends Controller
{
    /**
     * Empresa sube evidencia del reclamo.
     */
    public function submitEvidence(Request $request, TimeEntry $entry)
    {
        abort_unless($entry->contract->engagement->company_id === auth()->id(), 403);
        abort_unless($entry->status === TimeEntry::STATUS_DISPUTED, 400);

        $request->validate([
            'evidence_files'   => 'required|array|min:1|max:5',
            'evidence_files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'evidence_notes'   => 'nullable|string|max:1000',
        ]);

        $stored = [];
        foreach ($request->file('evidence_files') as $file) {
            $path = $file->store("fraccional/evidence/{$entry->id}", 'public');
            $stored[] = [
                'path'          => $path,
                'original_name' => $file->getClientOriginalName(),
                'size'          => $file->getSize(),
                'mime'          => $file->getMimeType(),
                'uploaded_at'   => now()->toIso8601String(),
            ];
        }

        $entry->update([
            'status'         => TimeEntry::STATUS_EVIDENCE_SUBMITTED,
            'evidence_files' => $stored,
            'dispute_reason' => $entry->dispute_reason . "\n\n[Notas adicionales]: " . ($request->evidence_notes ?? ''),
        ]);

        ChatSystemMessenger::post($entry->contract->engagement, 'evidence_submitted', [
            'entry_id'    => $entry->id,
            'hours'       => $entry->hours,
            'worked_on'   => $entry->worked_on->format('d/m/Y'),
            'files_count' => count($stored),
        ]);

        return back()->with('success', 'Evidencia enviada al profesional.');
    }

    /**
     * Profesional acepta la evidencia: la entrada se resuelve a favor de la empresa
     * (las horas no cuentan).
     */
    public function acceptEvidence(TimeEntry $entry)
    {
        abort_unless($entry->professional_id === auth()->id(), 403);
        abort_unless($entry->status === TimeEntry::STATUS_EVIDENCE_SUBMITTED, 400);

        $entry->update([
            'status'                         => TimeEntry::STATUS_RESOLVED_COMPANY,
            'professional_accepted_evidence' => true,
            'professional_responded_at'      => now(),
        ]);

        ChatSystemMessenger::post($entry->contract->engagement, 'evidence_accepted', [
            'entry_id' => $entry->id,
            'hours'    => $entry->hours,
        ]);

        return back()->with('success', 'Aceptaste la evidencia. Estas horas no se cobrarán.');
    }

    /**
     * Profesional rechaza la evidencia: pasa a mediación de Pipol.
     */
    public function rejectEvidence(Request $request, TimeEntry $entry)
    {
        abort_unless($entry->professional_id === auth()->id(), 403);
        abort_unless($entry->status === TimeEntry::STATUS_EVIDENCE_SUBMITTED, 400);

        $data = $request->validate([
            'professional_response' => 'required|string|min:10|max:2000',
        ]);

        $entry->update([
            'status'                         => TimeEntry::STATUS_IN_MEDIATION,
            'professional_response'          => $data['professional_response'],
            'professional_accepted_evidence' => false,
            'professional_responded_at'      => now(),
        ]);

        ChatSystemMessenger::post($entry->contract->engagement, 'mediation_started', [
            'entry_id' => $entry->id,
            'hours'    => $entry->hours,
        ]);

        // Notificar admin
        // Notification::route('mail', config('fraccional.admin_email'))
        //     ->notify(new DisputeNeedsMediation($entry));

        return back()->with('info',
            'Tu respuesta fue enviada. El equipo de Pipol mediará en breve.');
    }
}