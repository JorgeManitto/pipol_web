<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    //
    protected $table = 'reviews';
    protected $fillable = [
        'session_id',
        'mentee_id',
        'mentor_id',
        'rating',
        'comment',
        'visible',
    ];
    public function session()
    {
        return $this->belongsTo(Pipol_sessions::class);
    }
}
