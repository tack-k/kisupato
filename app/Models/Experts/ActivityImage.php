<?php

namespace App\Models\Experts;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ActivityImage extends Model {
    use HasFactory, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'expert_profile_id',
        'acitivity_image'
    ];

    public function scopeCheckSameImage($query, $image) {
        return $query->where('activity_image', $image)->exists();
    }

    /**
     * 活動写真を持つプロフィールを取得
     */
    public function expertProfile() {
        $this->belongsTo(ExpertProfile::class);
    }
}
