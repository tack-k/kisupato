<?php

namespace App\Models\Admins;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;


class Department extends Model
{
    use HasFactory, AuthorObservable, softDeletes;

    protected $fillable = [
        'name',
    ];

    public function searchDepartments($keyword) {
        if (isset($keyword)) {
            $departments = self::select('departments.id', 'departments.name', 'departments.created_at', 'departments.updated_at')
                ->where('departments.deleted_at', '=', null)
                ->where(function ($query) use ($keyword) {
                    $query->where('departments.name', 'like', "%{$keyword}%")
                    ->orwhere('departments.created_at', 'like', "%{$keyword}%")
                    ->orwhere('departments.updated_at', 'like', "%{$keyword}%");
                })
                ->orderBy('departments.created_at', 'desc')
                ->paginate(5)
                ->appends(['keyword' => $keyword]);

        } else {
            $departments = self::select('departments.id', 'departments.name', 'departments.created_at', 'departments.updated_at')
                ->where('departments.deleted_at', '=', null)
                ->orderBy('departments.created_at', 'desc')
                ->paginate(5);
        }
        return $departments;
    }

    public function admins()
    {
        $this->hasMany(Admin::class);
    }
}
