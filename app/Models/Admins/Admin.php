<?php

namespace App\Models\Admins;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use App\Traits\AuthorObservable;


class Admin extends Authenticatable
{
    use HasFactory, Notifiable, AuthorObservable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_number',
        'authority_id',
        'department_id',
        'last_name',
        'first_name',
        'first_name_kana',
        'last_name_kana',
        'email',
        'password',
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
        $url = url(route('admin.password.reset', ['token' => $token], false));

        $this->notify(new ResetPasswordNotification($url));
    }

    public function searchAdmins($keyword) {
        if (isset($keyword)) {
            $admins = Admin::select('admins.*', 'authorities.name AS authority_name', 'departments.name AS department_name')
                ->leftJoin('authorities', 'admins.authority_id', '=', 'authorities.id')
                ->leftJoin('departments', 'admins.department_id', '=', 'departments.id')
                ->where('admins.deleted_at', '=', null)
                ->where(function ($query) use ($keyword) {
                    $query->where(DB::raw('CONCAT(admins.last_name, admins.first_name)'), 'like', "%{$keyword}%")
                        ->orwhere('admins.staff_number', 'like', "%{$keyword}%")
                        ->orwhere('departments.name', 'like', "%{$keyword}%")
                        ->orwhere('authorities.name', 'like', "%{$keyword}%");
                })
                ->orderBy('admins.created_at', 'desc')
                ->paginate(5)
                ->appends(['keyword' => $keyword]);

        } else {
            $admins = Admin::select('admins.*', 'authorities.name AS authority_name', 'departments.name AS department_name')
                ->leftJoin('authorities', 'admins.authority_id', '=', 'authorities.id')
                ->leftJoin('departments', 'admins.department_id', '=', 'departments.id')
                ->where('admins.deleted_at', '=', null)
                ->orderBy('admins.created_at', 'desc')
                ->paginate(5);
        }
        return $admins;
    }

    public function authority() {
        $this->belongsTo(Authority::class);
    }

    public function department() {
        $this->belongsTo(Department::class);
    }
}
