<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftSkill extends Model
{
    use HasFactory, AuthorObservable;

    protected $fillable = [
        'expert_profile_id',
        'skill_title',
        'skill_content',
    ];

    /**
     * 下書き提供技術を持つ下書きプロフィールを取得
     */
    public function expertProfile() {
        $this->belongsTo(ExpertProfile::class);
    }
}
