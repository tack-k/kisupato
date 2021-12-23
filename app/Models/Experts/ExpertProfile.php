<?php

namespace App\Models\Experts;

use App\Models\Admins\Position;
use App\Models\Admins\Tag;
use App\Models\Area;
use App\Models\ExpertProfilesTag;
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
     * 専門人材のプロフィール、提供スキル、活動写真を取得する
     * @param $query
     * @param $expert_id
     * @return mixed
     */
    public function scopeGetExpertProfileAllInfo($query, $expert_id) {
        return $query->select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content')
            ->with(['activityImages:id,expert_profile_id,activity_image', 'skills:id,expert_profile_id,skill_title,skill_content'])
            ->where('expert_id', $expert_id);

    }

    /**
     * 専門人材のプロフィール情報を取得する
     * @param $query
     * @param $expert_id
     * @return mixed
     */
    public function scopeGetExpertProfileInfo($query, $expert_id) {
        return $query->select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content')
            ->where('expert_id', $expert_id);
    }

    public function scopeCheckSameImage($query, $image) {
        return $query->where('profile_image', $image)->exists();
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

    /**
     * この専門人材プルフィールに属する人材タグ
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags() {
        return $this->belongsToMany(Tag::class, 'expert_profiles_tags')
            ->withTimestamps();
    }

    /**
     * この専門人材プロフィールに属する人材肩書
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function positions() {
        return $this->belongsToMany(Position::class, 'expert_profiles_positions')
            ->withTimestamps();
    }

    /**
     * この専門人材プロフィールに属する地域
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areas() {
        return $this->belongsToMany(Area::class, 'expert_profiles_areas')
            ->withTimestamps();
    }
}
