<?php

namespace App\Models\Admins;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationSite extends Model {

    use HasFactory, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'title',
        'description',
        'status',
        'reserved_at',
        'posted_at',
    ];


    public function scopeGetSearchedInformationSites($query, $keyword) {
        if (isset($keyword)) {
            return $query->select('id', 'title', 'reserved_at', 'status')
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%")
                        ->orWhere('reserved_at', 'like', "%{$keyword}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5)
                ->appends(['keyword' => $keyword]);
        } else {
            return $query->select('id', 'title', 'reserved_at', 'status')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function scopeGetInformationSite($query, $informationSiteId) {
        $query->select('id', 'title', 'description', 'reserved_at', 'status')
            ->where('id', $informationSiteId);
    }

}
