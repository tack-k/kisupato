<?php

namespace App\Models\Experts;

use App\Notifications\ResetPasswordNotification;
use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Expert extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'email',
        'tel',
        'postal_code',
        'region',
        'city',
        'street',
        'building',
        'gender',
        'birthday',
        'password',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url = url(route('expert.password.reset', ['token' => $token], false));

        $this->notify(new ResetPasswordNotification($url));
    }
}
