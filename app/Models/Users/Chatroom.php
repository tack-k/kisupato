<?php

namespace App\Models\Users;

use App\Models\Experts\Expert;
use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    protected $fillable = [
        'user_id',
        'expert_id',
        'consultation_status',
        'request_status',
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

        $query->select('chatrooms.id as chatroom_id', 'consultation_status', 'request_status', 'chatrooms.created_at as c_created_at', 'chatrooms.updated_at as c_updated_at', 'ep.nickname', 'ep.profile_image', 'm.message', 'm.created_at as m_created_at')
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
