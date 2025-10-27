<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor_skill extends Model
{
    //
    protected $table = 'mentor_skills';
    protected $fillable = ['mentor_id', 'skill_id', 'experience_years'];
}
