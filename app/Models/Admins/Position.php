<?php

namespace App\Models\Admins;

use App\Models\Experts\ExpertProfile;
use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, AuthorObservable, softDeletes;

    protected $fillable = [
        'name',
    ];

    public function searchPositions($keyword) {
        if (isset($keyword)) {
            $positions = self::select('positions.id', 'positions.name', 'positions.created_at', 'positions.updated_at')
                ->where('positions.deleted_at', '=', null)
                ->where(function ($query) use ($keyword) {
                    $query->where('positions.name', 'like', "%{$keyword}%")
                        ->orwhere('positions.created_at', 'like', "%{$keyword}%")
                        ->orwhere('positions.updated_at', 'like', "%{$keyword}%");
                })
                ->orderBy('positions.created_at', 'desc')
                ->paginate(5)
                ->appends(['keyword' => $keyword]);

        } else {
            $positions = self::select('positions.id', 'positions.name', 'positions.created_at', 'positions.updated_at')
                ->where('positions.deleted_at', '=', null)
                ->orderBy('positions.created_at', 'desc')
                ->paginate(5);
        }
        return $positions;
    }

    public function scopeGetPositions($query) {
        $query->select('id', 'name');
    }

    public function expertProfiles() {
        return $this->belongsToMany(ExpertProfile::class, 'expert_profiles_positions')
            ->withTimestamps();
    }
    
    public function mailMagazines() {
        return $this->belongsToMany(MailMagazine::class, 'mail_magazine_positions')
            ->withTimestamps();
    }
}
