<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    protected $table = 'transactions';

    protected $fillable = [
        'session_id',
        'payer_id',
        'receiver_id',
        'gateway',
        'gateway_transaction_id',
        'currency',
        'amount',
        'platform_fee',
        'mentor_earnings',
        'status',
        'notes',
        'paid_at',
        'refunded_at'
    ];

    public function session() {
    return $this->belongsTo(Pipol_sessions::class);
    }
    public function payer() {
        return $this->belongsTo(User::class, 'payer_id');
    }
    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
