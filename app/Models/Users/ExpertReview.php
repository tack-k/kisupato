<?php

namespace App\Models\Users;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ExpertReview extends Model {

    use HasFactory, Notifiable, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'chatroom_id',
        'expert_id',
        'user_id',
        'comment',
        'evaluation',
    ];

    /**
     * ユーザーが行ったレビューを取得
     * @param $query
     * @param $userId
     */
    public function scopeGetSelfReviews($query, $userId) {
        $query->select('expert_reviews.id', 'expert_reviews.evaluation', 'expert_reviews.comment', 'expert_reviews.created_at', 'ep.nickname', 'ep.profile_image')
            ->join('expert_profiles as ep', 'expert_reviews.expert_id', '=', 'ep.expert_id')
            ->where('expert_reviews.user_id', $userId)
            ->orderBy('expert_reviews.created_at', 'desc');

    }

    public function scopeGetExpertReviews($query, $expertId) {

        $query->select('expert_reviews.id', 'expert_reviews.evaluation', 'expert_reviews.comment', 'expert_reviews.created_at', 'ep.nickname', 'up.profile_image')
            ->join('expert_profiles as ep', 'expert_reviews.expert_id', '=', 'ep.expert_id')
            ->join('user_profiles as up', 'expert_reviews.user_id', '=', 'up.user_id')
            ->where('expert_reviews.expert_id', $expertId)
            ->orderBy('expert_reviews.created_at', 'desc');
    }
}
