<?php

namespace App\Models\Admins;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContactTitle extends Model
{
    use HasFactory, AuthorObservable, softDeletes;

    protected $fillable = [
        'name',
    ];

    public function searchUserContactTitles($keyword) {
        if (isset($keyword)) {
            $user_contact_titles = self::select('user_contact_titles.id', 'user_contact_titles.name', 'user_contact_titles.created_at', 'user_contact_titles.updated_at')
                ->where('user_contact_titles.deleted_at', '=', null)
                ->where(function ($query) use ($keyword) {
                    $query->where('user_contact_titles.name', 'like', "%{$keyword}%")
                        ->orwhere('user_contact_titles.created_at', 'like', "%{$keyword}%")
                        ->orwhere('user_contact_titles.updated_at', 'like', "%{$keyword}%");
                })
                ->orderBy('user_contact_titles.created_at', 'desc')
                ->paginate(5)
                ->appends(['keyword' => $keyword]);

        } else {
            $user_contact_titles = self::select('user_contact_titles.id', 'user_contact_titles.name', 'user_contact_titles.created_at', 'user_contact_titles.updated_at')
                ->where('user_contact_titles.deleted_at', '=', null)
                ->orderBy('user_contact_titles.created_at', 'desc')
                ->paginate(5);
        }
        return $user_contact_titles;
    }
}
