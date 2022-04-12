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

}
