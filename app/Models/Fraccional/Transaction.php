<?php
namespace App\Models\Fraccional;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'fraccional_transactions';
    protected $guarded = [];
    protected $casts = [
        'paid_at' => 'datetime', 'released_at' => 'datetime', 'refunded_at' => 'datetime',
    ];

    public function contract()     { return $this->belongsTo(Contract::class); }
    public function engagement()   { return $this->belongsTo(Engagement::class); }
    public function company()      { return $this->belongsTo(User::class, 'company_id'); }
    public function professional() { return $this->belongsTo(User::class, 'professional_id'); }
}