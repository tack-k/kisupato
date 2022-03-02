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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function expert() {
        return $this->belongsTo(Expert::class);
    }
}
