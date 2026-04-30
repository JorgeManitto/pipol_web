<?php
namespace App\Models\Fraccional;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    protected $table = 'fraccional_engagements';
    protected $guarded = [];
    protected $casts = [
        'accepted_at' => 'datetime', 'rejected_at' => 'datetime',
        'activated_at' => 'datetime', 'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function diagnostic()   { return $this->belongsTo(Diagnostic::class); }
    public function company()      { return $this->belongsTo(User::class, 'company_id'); }
    public function professional() { return $this->belongsTo(User::class, 'professional_id'); }
    public function conversation() { return $this->hasOne(Conversation::class); }
    public function contract()     { return $this->hasOne(Contract::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }

    public function involves(int $userId): bool
    {
        return in_array($userId, [$this->company_id, $this->professional_id]);
    }
}