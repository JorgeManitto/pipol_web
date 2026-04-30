<?php
namespace App\Models\Fraccional;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    protected $table = 'fraccional_time_entries';
    protected $guarded = [];
    protected $casts = [
    'worked_on'                       => 'date',
    'hours'                           => 'decimal:2',
    'review_deadline_at'              => 'datetime',
    'reviewed_at'                     => 'datetime',
    'disputed_at'                     => 'datetime',
    'evidence_files'                  => 'array',
    'professional_responded_at'       => 'datetime',
    'professional_accepted_evidence'  => 'boolean',
    'mediated_at'                     => 'datetime',
    'approved_hours_after_mediation'  => 'decimal:2',
];

    public const STATUS_EVIDENCE_SUBMITTED  = 'evidence_submitted';
    public const STATUS_IN_MEDIATION        = 'in_mediation';
    public const STATUS_RESOLVED_COMPANY    = 'resolved_company';
    public const STATUS_RESOLVED_PROFESSIONAL = 'resolved_professional';
    public const STATUS_RESOLVED_PARTIAL    = 'resolved_partial';

    public const STATUS_PENDING        = 'pending';
    public const STATUS_APPROVED       = 'approved';
    public const STATUS_AUTO_APPROVED  = 'auto_approved';
    public const STATUS_DISPUTED       = 'disputed';

    public function contract()     { return $this->belongsTo(Contract::class); }
    public function professional() { return $this->belongsTo(User::class, 'professional_id'); }
    public function reviewer()     { return $this->belongsTo(User::class, 'reviewed_by'); }

    public function isPending(): bool   { return $this->status === self::STATUS_PENDING; }
    public function isResolved(): bool  { return in_array($this->status, [self::STATUS_APPROVED, self::STATUS_AUTO_APPROVED]); }
    public function isDisputed(): bool  { return $this->status === self::STATUS_DISPUTED; }
    public function counts(): bool      { return $this->isResolved(); } // solo cuentan al total las aprobadas

    public function deadlineRemaining(): ?int
    {
        if (!$this->review_deadline_at || !$this->isPending()) return null;
        return max(0, now()->diffInSeconds($this->review_deadline_at, false));
    }

    public function mediator() { return $this->belongsTo(User::class, 'mediator_id'); }
    public function isInDisputeFlow(): bool
    {
        return in_array($this->status, [
            self::STATUS_DISPUTED,
            self::STATUS_EVIDENCE_SUBMITTED,
            self::STATUS_IN_MEDIATION,
        ]);
    }

    public function isResolvedDispute(): bool
    {
        return in_array($this->status, [
            self::STATUS_RESOLVED_COMPANY,
            self::STATUS_RESOLVED_PROFESSIONAL,
            self::STATUS_RESOLVED_PARTIAL,
        ]);
    }
    /**
     * Horas que efectivamente cuentan (cuánto se le paga al profesional).
     */
    public function effectiveHours(): float
    {
        if (in_array($this->status, [self::STATUS_APPROVED, self::STATUS_AUTO_APPROVED, self::STATUS_RESOLVED_PROFESSIONAL])) {
            return (float) $this->hours;
        }
        if ($this->status === self::STATUS_RESOLVED_PARTIAL) {
            return (float) ($this->approved_hours_after_mediation ?? 0);
        }
        return 0; // pending, disputed, en mediación, resolved_company → no cuentan
    }
}