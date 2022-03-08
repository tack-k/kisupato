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

    public function scopeGetMessages($query, $chatroomId) {
        return $query->select(['message', 'messages.created_at', 'user_id', 'messages.expert_id', 'ep.profile_image'])
            ->leftjoin('expert_profiles as ep', 'ep.id', '=', 'messages.expert_id')
            ->where('chatroom_id', $chatroomId)
            ->orderBy('created_at', 'asc');
    }

    public function chatroom()
    {
        return $this->belongsTo(Chatroom::class);
    }
}
