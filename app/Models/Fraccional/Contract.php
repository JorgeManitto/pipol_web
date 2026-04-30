<?php
namespace App\Models\Fraccional;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'fraccional_contracts';
    protected $guarded = [];
    protected $casts = [
        'start_date'             => 'date',
        'end_date'               => 'date',
        'professional_signed_at' => 'datetime',
        'company_signed_at'      => 'datetime',
        'terms_accepted_at'      => 'datetime',
        'last_proposed_at'       => 'datetime',
        'proposal_history'       => 'array',
    ];


    public function engagement()   { return $this->belongsTo(Engagement::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }

    public function isFullySigned(): bool
    {
        return $this->professional_signed_at
            && $this->company_signed_at
            && $this->terms_accepted_at;
    }
    public function timeEntries() { return $this->hasMany(TimeEntry::class)->latest('worked_on'); }

    public function totalHours(): float
    {
        $entries = $this->timeEntries()->get();
        return (float) $entries->sum(fn($e) => $e->effectiveHours());
    }

    public function pendingHours(): float
    {
        return (float) $this->timeEntries()
            ->where('status', 'pending')
            ->sum('hours');
    }

    public function disputedHours(): float
    {
        return (float) $this->timeEntries()
            ->where('status', 'disputed')
            ->sum('hours');
    }
    public function lastProposedBy() { return $this->belongsTo(User::class, 'last_proposed_by'); }

    public function isProposedByCompany(): bool
    {
        return $this->last_proposed_by === $this->engagement->company_id;
    }

    public function isProposedByProfessional(): bool
    {
        return $this->last_proposed_by === $this->engagement->professional_id;
    }

    /**
     * Snapshot de los términos actuales para guardar en historial.
     */
    public function snapshotTerms(): array
    {
        return [
            'version'              => $this->version,
            'objectives'           => $this->objectives,
            'responsibilities'     => $this->responsibilities,
            'scope'                => $this->scope,
            'hours_per_week'       => $this->hours_per_week,
            'duration_months'      => $this->duration_months,
            'monthly_rate'         => (float) $this->monthly_rate,
            'currency'             => $this->currency,
            'start_date'           => $this->start_date?->toDateString(),
            'proposed_by'          => $this->last_proposed_by,
            'proposed_at'          => $this->last_proposed_at?->toIso8601String(),
            'counter_note'         => $this->counter_proposal_note,
        ];
    }
    
}