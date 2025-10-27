<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    //
    protected $table = 'reviews';
    // Review.php
    public function session()
    {
        return $this->belongsTo(Pipol_sessions::class);
    }
}
