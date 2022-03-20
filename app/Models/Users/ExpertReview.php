<?php

namespace App\Models\Users;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ExpertReview extends Model {

    use HasFactory, Notifiable, SoftDeletes, AuthorObservable;

    protected $fillable = [
      'expert_id',
      'user_id',
      'comment',
      'evaluation',
    ];
}
