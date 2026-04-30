<?php
namespace App\Console\Commands;

use App\Models\Fraccional\TimeEntry;
use App\Services\Fraccional\ChatSystemMessenger;
use Illuminate\Console\Command;

class AutoApproveTimeEntries extends Command
{
    protected $signature = 'fraccional:auto-approve-hours';
    protected $description = 'Auto-aprueba entradas de horas pendientes con deadline vencido (72hs).';

    public function handle(): int
    {
        $entries = TimeEntry::where('status', TimeEntry::STATUS_PENDING)
            ->where('review_deadline_at', '<=', now())
            ->with('contract.engagement')
            ->get();

        $count = 0;
        foreach ($entries as $entry) {
            $entry->update([
                'status'      => TimeEntry::STATUS_AUTO_APPROVED,
                'reviewed_at' => now(),
            ]);

            ChatSystemMessenger::post($entry->contract->engagement, 'time_entry_auto_approved', [
                'entry_id'  => $entry->id,
                'hours'     => $entry->hours,
                'worked_on' => $entry->worked_on->format('d/m/Y'),
            ]);

            $count++;
        }

        $this->info("Auto-aprobadas: {$count} entradas.");
        return self::SUCCESS;
    }
}