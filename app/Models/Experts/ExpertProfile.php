<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExpertProfile extends Model
{
    use HasFactory, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'expert_id',
        'status',
        'nickname',
        'profile_image',
        'self_introduction',
        'activity_title',
        'activity_content',
    ];

    /**
     * 専門人材の下書きプロフィール情報を取得する
     * @param $query
     * @param $expert_id
     * @return mixed
     */
    public function scopeGetExpertProfileInfo($query, $expert_id) {
        return $query->select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content')
            ->firstWhere('expert_id', $expert_id);
    }

    /**
     * プロフィールが持つ提供技術を取得
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skills() {
        return $this->hasMany(Skill::class);
    }

    /**
     * プロフィールが持つ活動写真を取得
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activityImages() {
        return $this->hasMany(ActivityImage::class);
    }
}
