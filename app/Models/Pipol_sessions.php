<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pipol_sessions extends Model
{
    protected $table = 'pipol_sessions';
    protected $fillable = [
        'mentor_id', 'mentee_id', 'scheduled_at', 'duration_minutes',
        'status', 'payment_status', 'price', 'currency'
    ];

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
        return $this->hasOne(Reviews::class,'session_id');
    }
    public function transaction() {
        return $this->hasOne(Transaction::class);
    }
    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
   
}
