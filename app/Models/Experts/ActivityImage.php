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

    public function getActivityImageInfo($profile_id) {
        return DB::table('activity_images AS ai')
            ->select('ai.id', 'ai.expert_profile_id', 'ai.activity_image')
            ->where('expert_profile_id', $profile_id)
            ->get();
    }
}
