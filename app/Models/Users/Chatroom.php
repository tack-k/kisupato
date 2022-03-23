<?php

namespace App\Models\Users;

use App\Consts\CommonConst;
use App\Models\Experts\Expert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chatroom extends Model
{
    protected $fillable = [
        'user_id',
        'expert_id',
        'consultation_status',
        'request_status',
        'request_finished_at',
    ];

    public function scopeGetChatroom($query, $userId, $expertId) {
        $query->select('id')
            ->where('expert_id', $expertId)
            ->where('user_id', $userId)
            ->where('consultation_status', '0');
    }

    public function scopeGetChatrooms($query, $userId) {
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
            ->where('chatrooms.user_id', $userId)
            ->distinct();
    }

    /**
     * ユーザーがレビューしていないチャットルームを取得する
     * @param $query
     * @param $userId
     */
    public function scopeGetChatroomsRewviewYet($query, $userId) {
        $reviewTerm = CommonConst::REVIEW_TERM;

        $query->select('chatrooms.id', 'ep.nickname', 'ep.profile_image', 'ep.expert_id', 'request_finished_at')
            ->join('expert_profiles as ep', 'ep.expert_id', '=', 'chatrooms.expert_id')
            ->whereNotExists(function ($query) {
                $query->from('expert_reviews as er')
                    ->whereColumn('er.chatroom_id', 'chatrooms.id');
            })
            ->where('chatrooms.user_id', $userId)
            ->where('chatrooms.request_status', CommonConst::REQUEST_FINISHED)
            ->where(function ($query) use ($reviewTerm) {
                $query->whereRaw("date_format(request_finished_at, '%Y-%m-%d') > any (select date_add(date_format(now(), '%Y-%m-%d'), INTERVAL -{$reviewTerm} DAY) from chatrooms)");
            });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function expert() {
        return $this->belongsTo(Expert::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
