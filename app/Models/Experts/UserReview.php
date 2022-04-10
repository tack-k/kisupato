<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserReview extends Model {

    use HasFactory, Notifiable, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'chatroom_id',
        'expert_id',
        'user_id',
        'comment',
        'evaluation',
    ];

    /**
     * 専門人材が行ったレビューを取得
     * @param $query
     * @param $expertId
     */
    public function scopeGetSelfReviews($query, $expertId) {
        $query->select('user_reviews.id', 'user_reviews.evaluation', 'user_reviews.comment', 'user_reviews.created_at', 'up.nickname', 'up.profile_image')
            ->join('user_profiles as up', 'user_reviews.user_id', '=', 'up.user_id')
            ->where('user_reviews.user_id', $expertId)
            ->orderBy('user_reviews.created_at', 'desc');

    }

    public function scopeGetUserReviews($query, $userId) {

        $query->select('user_reviews.id', 'user_reviews.evaluation', 'user_reviews.comment', 'user_reviews.created_at', 'up.nickname', 'up.profile_image')
            ->join('user_profiles as up', 'user_reviews.user_id', '=', 'up.user_id')
            ->join('user_profiles as up', 'user_reviews.user_id', '=', 'up.user_id')
            ->where('user_reviews.user_id', $userId)
            ->orderBy('user_reviews.created_at', 'desc');
    }

}
