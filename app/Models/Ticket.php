<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // Ticket.php
    protected $table = 'tickets';
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function session() {
        return $this->belongsTo(Pipol_sessions::class);
    }
    public function admin() {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }
}
