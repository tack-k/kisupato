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
