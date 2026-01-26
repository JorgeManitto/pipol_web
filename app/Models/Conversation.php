<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
 protected $fillable = [
        'participant_1_id',
        'participant_2_id',
        'last_message_at',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function participant1()
    {
        return $this->belongsTo(User::class, 'participant_1_id');
    }

    public function participant2()
    {
        return $this->belongsTo(User::class, 'participant_2_id');
    }

    public function otherUser($authId)
    {
        return $this->participant_1_id === $authId
            ? $this->participant2
            : $this->participant1;
    }
}
