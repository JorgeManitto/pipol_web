<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pipol_sessions extends Model
{
    protected $table = 'pipol_sessions';
    protected $fillable = [
        'mentor_id', 'mentee_id', 'scheduled_at', 'duration_minutes',
        'status', 'payment_status', 'price', 'currency',
        'reschedule_pending', 'original_scheduled_at', 'meet_link'
    ];

    protected $casts = [
        'scheduled_at'          => 'datetime',
        'original_scheduled_at' => 'datetime',
        'reschedule_pending'    => 'boolean',
    ];

    /* ── Relaciones ── */

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    public function review()
    {
        return $this->hasOne(Reviews::class, 'session_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'session_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /* ── Helpers ── */

    /**
     * ¿Queda más de 48 h para el inicio de la sesión?
     */
    public function isModifiableByMentor(): bool
    {
        return Carbon::parse($this->scheduled_at)
            ->greaterThanOrEqualTo(now()->addHours(48));
    }
}