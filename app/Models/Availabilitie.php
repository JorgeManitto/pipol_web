<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availabilitie extends Model
{
    protected $fillable = [
        'mentor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'is_recurring',
        'active',
    ];
}
