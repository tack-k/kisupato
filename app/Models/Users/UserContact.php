<?php

namespace App\Models\Users;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContact extends Model {

    use HasFactory, AuthorObservable, softDeletes;

    protected $fillable = [
        'user_contact_title_id',
        'user_id',
        'name',
        'email',
        'tel',
        'content',
        'status',
    ];

}
