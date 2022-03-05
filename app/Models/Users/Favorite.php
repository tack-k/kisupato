<?php

namespace App\Models\Users;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {

    use HasFactory, AuthorObservable;

    protected $fillable = [
        'user_id',
        'expert_id',
    ];

    /**
     * 特定の人材の、特定のお気に入り情報を取得
     * @param $query
     * @param $expertId
     * @param $userId
     * @return mixed
     */
    public function scopeGetFavorite($query, $expertId, $userId) {
        return $query->select('id')
            ->where('expert_id', $expertId)
            ->where('user_id', $userId);
    }

    /**
     * ユーザーのお気に入り情報を取得
     * @param $query
     * @param $expertId
     * @param $userId
     * @return mixed
     */
    public function scopeGetUserFavorite($query, $userId) {
        return $query->select('id', 'expert_id')
            ->where('user_id', $userId);
    }

    public function scopeGetFavoriteAndExpertProfileInfo($query, $userId) {
        return $query->selectRaw('GROUP_CONCAT(ai.activity_image) as activity_image, ep.expert_id, ep.id as expert_profile_id, nickname, profile_image, activity_title, activity_content, favorites.id as favorite_id, GROUP_CONCAT(DISTINCT t.name) as tags, GROUP_CONCAT(DISTINCT p.name) as positions')
            ->join('expert_profiles as ep', 'ep.expert_id', '=', 'favorites.expert_id')
            ->join('activity_images as ai', 'ep.id', '=', 'ai.expert_profile_id')
            ->join('expert_profiles_tags as ept', 'ept.expert_profile_id', '=', 'ep.id')
            ->join('tags as t', 't.id', '=', 'ept.tag_id')
            ->join('expert_profiles_positions as epp', 'epp.expert_profile_id', '=', 'ep.id')
            ->join('positions as p', 'p.id', '=', 'epp.position_id')
            ->where('favorites.user_id', $userId)
            ->where('ep.status', '0')
            ->groupBy('ai.expert_profile_id')
            ->groupBy('ep.id')
            ->groupBy('favorites.id')
            ->orderBy('favorites.created_at', 'desc');
    }
}
