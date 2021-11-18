<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftExpertProfile extends Model
{
    use HasFactory, AuthorObservable;

    protected $fillable = [
        'expert_id',
        'status',
        'nickname',
        'profile_image',
        'self_introduction',
        'activity_title',
        'activity_content',
        'saved_flag'
    ];

    /**
     * 一時保存したプロフィールが存在するかチェックする
     * @param $query
     * @param $expert_id
     * @return mixed
     */
    public function scopeCheckTemporarilySaved($query, $expert_id) {
       return $query->where('expert_id', $expert_id)->exists();
    }


    /**
     * 専門人材の下書きプロフィール情報を取得する
     * @param $query
     * @param $expert_id
     * @return mixed
     */
    public function scopeGetDraftExpertProfileInfo($query, $expert_id) {
        return $query->select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content')
            ->where('expert_id', $expert_id);
    }

    /**
     * 専門人材の下書きプロフィール、提供スキル、活動写真を取得する
     * @param $query
     * @param $expert_id
     * @return mixed
     */
    public function scopeGetDraftExpertProfileAllInfo($query, $expert_id) {
        return $query->select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content')
            ->with(['draftActivityImages:id,draft_expert_profile_id,activity_image', 'draftSkills:id,draft_expert_profile_id,skill_title,skill_content'])
            ->where('expert_id', $expert_id);

    }

    /**
     * 下書きプロフィールが持つ下書き提供技術を取得
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function draftSkills() {
        return $this->hasMany(DraftSkill::class);
    }

    /**
     * 下書きプロフィールが持つ下書き活動写真を取得
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function draftActivityImages() {
        return $this->hasMany(DraftActivityImage::class);
    }
}
