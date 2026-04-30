<?php
namespace App\Models\Fraccional;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    protected $table = 'fraccional_diagnostics';
    protected $guarded = [];
    protected $casts = ['ai_insights' => 'array'];

    public function company() { return $this->belongsTo(User::class, 'company_id'); }
    public function engagements() { return $this->hasMany(Engagement::class); }
}