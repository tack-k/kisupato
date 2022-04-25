<?php

namespace App\Models\Admins;

use App\Models\Experts\ExpertProfile;
use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, AuthorObservable, softDeletes;

    protected $fillable = [
        'name',
    ];

    public function searchTags($keyword) {
        if (isset($keyword)) {
            $tags = self::select('tags.id', 'tags.name', 'tags.created_at', 'tags.updated_at')
                ->where('tags.deleted_at', '=', null)
                ->where(function ($query) use ($keyword) {
                    $query->where('tags.name', 'like', "%{$keyword}%")
                        ->orwhere('tags.created_at', 'like', "%{$keyword}%")
                        ->orwhere('tags.updated_at', 'like', "%{$keyword}%");
                })
                ->orderBy('tags.created_at', 'desc')
                ->paginate(5)
                ->appends(['keyword' => $keyword]);

        } else {
            $tags = self::select('tags.id', 'tags.name', 'tags.created_at', 'tags.updated_at')
                ->where('tags.deleted_at', '=', null)
                ->orderBy('tags.created_at', 'desc')
                ->paginate(5);
        }
        return $tags;
    }

    public function scopeGetTags($query)
    {
        $query->select('id', 'name');
    }

    /**
     * この人材タグに属する専門人材プロフィール
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function expertProfiles() {
        return $this->belongsToMany(ExpertProfile::class, 'expert_profiles_tags')
            ->withTimestamps();
    }

    public function mailMagazines() {
        return $this->belongsToMany(MailMagazine::class, 'mail_magazine_tags')
            ->withTimestamps();
    }
}
