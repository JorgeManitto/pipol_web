<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    protected $table = 'transactions';
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
