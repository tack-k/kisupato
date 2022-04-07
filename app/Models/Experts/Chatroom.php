<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Chatroom extends Model {

    use HasFactory, Notifiable, SoftDeletes, AuthorObservable;

    public function scopeGetChatrooms($query, $expertId) {
        $latestMessage = \DB::table('messages')
            ->join('chatrooms as c', 'c.id', '=', 'messages.chatroom_id')
            ->selectRaw('messages.user_id, MAX(messages.created_at) as latest_message_created_at')
            ->where('c.expert_id', $expertId)
            ->groupBy('messages.user_id');

        $query->select('chatrooms.id as chatroom_id', 'consultation_status', 'request_status', 'chatrooms.created_at as c_created_at', 'chatrooms.updated_at as c_updated_at', 'request_finished_at', 'up.nickname', 'up.profile_image', 'm.message', 'm.created_at as m_created_at')
            ->join('user_profiles as up', 'up.user_id', '=', 'chatrooms.user_id')
            ->leftjoin('messages as m', function ($join) {
                $join->on( 'm.chatroom_id', '=', 'chatrooms.id')
                    ->whereNull('m.expert_id');
            })
            ->joinSub($latestMessage, 'latest_message', function ($join) {
                $join->on('m.created_at', '=', 'latest_message.latest_message_created_at')
                    ->orWhereNull('m.expert_id')
                    ->whereNull('m.user_id');
            })
            ->where('chatrooms.expert_id', $expertId)
            ->distinct();
    }

}
