<?php

namespace App\Models\Admins;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpertContactTitle extends Model
{
    use HasFactory, AuthorObservable, softDeletes;

    protected $fillable = [
        'name',
    ];

    public function searchExpertContactTitles($keyword) {
        if (isset($keyword)) {
            $expert_contact_titles = self::select('expert_contact_titles.id', 'expert_contact_titles.name', 'expert_contact_titles.created_at', 'expert_contact_titles.updated_at')
                ->where('expert_contact_titles.deleted_at', '=', null)
                ->where(function ($query) use ($keyword) {
                    $query->where('expert_contact_titles.name', 'like', "%{$keyword}%")
                        ->orwhere('expert_contact_titles.created_at', 'like', "%{$keyword}%")
                        ->orwhere('expert_contact_titles.updated_at', 'like', "%{$keyword}%");
                })
                ->orderBy('expert_contact_titles.created_at', 'desc')
                ->paginate(5)
                ->appends(['keyword' => $keyword]);

        } else {
            $expert_contact_titles = self::select('expert_contact_titles.id', 'expert_contact_titles.name', 'expert_contact_titles.created_at', 'expert_contact_titles.updated_at')
                ->where('expert_contact_titles.deleted_at', '=', null)
                ->orderBy('expert_contact_titles.created_at', 'desc')
                ->paginate(5);
        }
        return $expert_contact_titles;
    }
}
