<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'chatroom_id',
        'message',
        'user_id',
        'expert_id',
    ];

    public function chatroom()
    {
        return $this->belongsTo(Chatroom::class);
    }
}
