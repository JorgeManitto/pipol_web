<?php
namespace App\Models\Fraccional;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'fraccional_conversations';
    protected $guarded = [];
    protected $casts = ['last_message_at' => 'datetime'];

    public function engagement() { return $this->belongsTo(Engagement::class); }
    public function messages()   { return $this->hasMany(Message::class)->orderBy('created_at'); }
}
