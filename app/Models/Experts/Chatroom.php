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
            ->selectRaw('expert_id, MAX(created_at) as latest_message_created_at')
            ->groupBy('expert_id');

        $query->select('chatrooms.id as chatroom_id', 'consultation_status', 'request_status', 'chatrooms.created_at as c_created_at', 'chatrooms.updated_at as c_updated_at', 'request_finished_at', 'ep.nickname', 'ep.profile_image', 'm.message', 'm.created_at as m_created_at')
            ->join('expert_profiles as ep', 'ep.id', '=', 'chatrooms.expert_id')
            ->leftjoin('messages as m', function ($join) {
                $join->on( 'm.chatroom_id', '=', 'chatrooms.id')
                    ->whereNull('m.user_id');
            })
            ->joinSub($latestMessage, 'latest_message', function ($join) {
                $join->on('m.created_at', '=', 'latest_message.latest_message_created_at')
                    ->orWhereNull('m.user_id')
                    ->whereNull('m.expert_id');
            })
            ->where('chatrooms.expert_id', $expertId)
            ->distinct();
    }

}
