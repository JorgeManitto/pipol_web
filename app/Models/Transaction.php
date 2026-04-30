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
        'refunded_at',
        'mentor_amount',
        'transfer_status',
        'stripe_transfer_id',
        'transferred_at',
    ];

    protected $casts = [
        'paid_at'        => 'datetime',
        'transferred_at' => 'datetime',
        'amount'         => 'decimal:2',
        'platform_fee'   => 'decimal:2',
        'mentor_amount'  => 'decimal:2',
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
