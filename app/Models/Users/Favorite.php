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
}
