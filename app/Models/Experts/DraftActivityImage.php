<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DraftActivityImage extends Model
{
    use HasFactory, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'expert_profile_id',
        'acitivity_image'
    ];

    /**
     * 下書き活動写真を持つ下書きプロフィールを取得
     */
    public function expertProfile() {
        $this->belongsTo(ExpertProfile::class);
    }
}
