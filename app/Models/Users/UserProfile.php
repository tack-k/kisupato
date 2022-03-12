<?php

namespace App\Models\Users;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model {

    use HasFactory, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'user_id',
        'nickname',
        'profile_image',
        'self_introduction'
    ];

    public function scopeGetUserProfile($query, $userId) {
        $query->select('id', 'user_id', 'nickname', 'self_introduction', 'profile_image')
            ->where('id', $userId);
    }
}
