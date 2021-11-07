<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Skill extends Model {
    use HasFactory, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'expert_profile_id',
        'skill_title',
        'skill_content',
    ];


    /**
     * 提供技術を持つプロフィールを取得
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ExpertProfile() {
        return $this->belongsTo(ExpertProfile::class);
    }
}
