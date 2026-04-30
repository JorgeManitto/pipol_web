<?php
namespace App\Models\Fraccional;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'fraccional_messages';
    protected $guarded = [];
    protected $casts = [
        'read_at' => 'datetime',
        'meta'    => 'array',
    ];

    public function conversation() { return $this->belongsTo(Conversation::class); }
    public function sender()       { return $this->belongsTo(User::class, 'sender_id'); }

    public function isSystem(): bool { return $this->type === 'system'; }
}