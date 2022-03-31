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
use Illuminate\Support\Facades\DB;


class ExpertProfile extends Model {
    use HasFactory, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'expert_id',
        'status',
        'nickname',
        'profile_image',
        'self_introduction',
        'activity_title',
        'activity_content',
        'activity_base',
        'latitude',
        'longitude',
    ];

    /**
     * 専門人材のプロフィール情報を取得する
     * @param $query
     * @param $expert_id
     * @return mixed
     */
    public function scopeGetExpertProfileInfo($query, $expert_id) {
        return $query->select('expert_profiles.id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content', 'activity_base', 'c.id AS city_id', 'c.name AS city_name')
            ->where('expert_id', $expert_id)
            ->leftjoin('cities AS c', 'expert_profiles.activity_base', '=', 'c.id')
            ->with('tags:id,name')
            ->with('positions:id,name')
            ->with(['activityImages:id,expert_profile_id,activity_image', 'skills:id,expert_profile_id,skill_title,skill_content']);
    }

    public function scopeCheckSameImage($query, $image) {
        return $query->where('profile_image', $image)->exists();
    }

    public function getAreas() {
        return DB::table('expert_profiles')->from('expert_profiles AS ep')
            ->select(DB::raw('a.name, a.id'))
            ->join('cities AS c', 'ep.activity_base', '=', 'c.id')
            ->join('areas AS a', 'c.area_id', '=', 'a.id')
            ->whereNull('ep.deleted_at')
            ->distinct()
            ->get();
    }


    public function getAreaAndCities() {
        return DB::table('expert_profiles')->from('expert_profiles AS ep')
            ->select(DB::raw('c.name AS city_name, count(c.name) AS city_count, c.id AS city_id , a.name AS area_name, a.id AS area_id'))
            ->join('cities AS c', 'ep.activity_base', '=', 'c.id')
            ->join('areas AS a', 'c.area_id', '=', 'a.id')
            ->whereNull('ep.deleted_at')
            ->groupBy('c.name')
            ->groupBy('c.id')
            ->groupBy('a.name')
            ->groupBy('a.id')
            ->get();
    }

    /**
     * カードに表示する専門人材プロフィール情報を取得
     * @param $query
     * @param null $tag
     * @param null $keyword
     * @param null $cityIds
     * @return mixed
     */

    public function scopeGetExpertProfileCard($query, $tag = null, $keyword = null, $cityIds = null) {

        return $query->selectRaw('GROUP_CONCAT(ai.activity_image) as activity_image, activity_base, expert_profiles.expert_id, expert_profiles.id as expert_profile_id, nickname, profile_image, activity_title, activity_content, expert_profiles.latitude, expert_profiles.longitude, f.id as favorite_id, GROUP_CONCAT(DISTINCT t.name) as tags, GROUP_CONCAT(DISTINCT p.name) as positions')
            ->join('activity_images as ai', 'expert_profiles.id', '=', 'ai.expert_profile_id')
            ->leftjoin('favorites as f', 'expert_profiles.expert_id', '=', 'f.expert_id')
            ->join('expert_profiles_tags as ept', 'ept.expert_profile_id', '=', 'expert_profiles.id')
            ->join('tags as t', 't.id', '=', 'ept.tag_id')
            ->join('expert_profiles_positions as epp', 'epp.expert_profile_id', '=', 'expert_profiles.id')
            ->join('positions as p', 'p.id', '=', 'epp.position_id')
            ->join('cities as c', 'activity_base', '=', 'c.id')
            ->when(isset($tag), function ($query) use ($tag) {
                $query->where('t.id', $tag);
            })
            ->When(isset($keyword), function ($query) use ($keyword) {
                foreach ($keyword as $word) {
                    $query->where(function ($query) use ($word) {
                        $query->where('nickname', 'like', "%{$word}%")
                            ->orWhere('t.name', 'like', "%{$word}%")
                            ->orWhere('activity_title', 'like', "%{$word}%")
                            ->orWhere('activity_content', 'like', "%{$word}%")
                            ->orWhere('self_introduction', 'like', "%{$word}%")
                            ->orWhere('c.name', 'like', "%{$word}%");
                    });
                }
            })
            ->when(isset($cityIds), function($query) use ($cityIds) {
                $query->whereIn('activity_base', $cityIds);
            })
            ->where('status', '0')
            ->take(50)
            ->groupBy('ai.expert_profile_id')
            ->groupBy('expert_profiles.id')
            ->groupBy('f.id')
            ->orderBy('expert_profiles.created_at', 'desc');
    }

    public function scopeGetExpertProfileForChatroom($query, $expertId) {
        $query->select('id', 'nickname', 'profile_image', 'self_introduction')
            ->where('id', $expertId);
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
