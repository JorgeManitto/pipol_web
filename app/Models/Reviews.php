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
    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
