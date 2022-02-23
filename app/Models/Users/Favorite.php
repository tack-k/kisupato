<?php

namespace App\Models\Users;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {

    use HasFactory, AuthorObservable;

    protected $fillable = [
        'user_id',
        'expert_id',
    ];

    public function scopeGetFavorite($query, $expertId, $userId) {
        return $query->select('id')
            ->where('expert_id', $expertId)
            ->where('user_id', $userId);
    }
}
