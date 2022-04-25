<?php

namespace App\Models\Admins;

use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MailMagazine extends Model {

    use HasFactory, Notifiable, SoftDeletes, AuthorObservable;

    protected $fillable = [
        'title',
        'description',
        'status',
        'posted_at',
        'reserved_at',
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class, 'mail_magazines_tags')
            ->withTimestamps();
    }

    public function positions() {
        return $this->belongsToMany(Position::class. 'mail_magazine_positions')
            ->withTimestamps();
    }
}
