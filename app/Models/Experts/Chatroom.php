<?php

namespace App\Models\Experts;

use App\Consts\CommonConst;
use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Chatroom extends Model {

    protected $fillable = [
        'user_id',
        'expert_id',
        'consultation_status',
        'request_status',
        'request_finished_at',
    ];

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

    public function scopeGetChatroomsReviewYet($query, $expertId) {
        $reviewTerm = CommonConst::REVIEW_TERM;

        $query->select('chatrooms.id', 'up.nickname', 'up.profile_image', 'up.user_id', 'request_finished_at')
            ->join('user_profiles as up', 'up.user_id', '=', 'chatrooms.user_id')
            ->whereNotExists(function ($query) {
                $query->from('user_reviews as ur')
                    ->whereColumn('ur.chatroom_id', 'chatrooms.id');
            })
            ->where('chatrooms.user_id', $expertId)
            ->where('chatrooms.request_status', CommonConst::REQUEST_FINISHED)
            ->where(function ($query) use ($reviewTerm) {
                $query->whereRaw("date_format(request_finished_at, '%Y-%m-%d') > any (select date_add(date_format(now(), '%Y-%m-%d'), INTERVAL -{$reviewTerm} DAY) from chatrooms)");
            });
    }

}
