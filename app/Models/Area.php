<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * 地域のすべての市町村を取得
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities() {
       return $this->hasMany(City::class);
    }
}
