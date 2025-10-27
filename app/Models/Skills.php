<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $table = 'skills';
    protected $fillable = ['name', 'slug','description'];
    public function mentors()
    {
        return $this->belongsToMany(User::class, 'mentor_skills', 'skill_id', 'mentor_id');
    }
}
