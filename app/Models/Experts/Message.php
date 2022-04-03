<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Message extends Model {

    use HasFactory, Notifiable, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'chatroom_id',
        'message',
        'user_id',
        'expert_id',
    ];

    public function scopeGetMessages($query, $chatroomId) {
        return $query->select(['message', 'messages.created_at', 'messages.user_id', 'messages.expert_id', 'up.profile_image'])
            ->leftjoin('user_profiles as up', 'up.id', '=', 'messages.user_id')
            ->where('chatroom_id', $chatroomId)
            ->orderBy('created_at', 'asc');
    }
}
