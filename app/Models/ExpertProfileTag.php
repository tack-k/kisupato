<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExpertProfileTag extends Pivot
{
    /**
     * IDの自動増分を指定する
     * @var bool
     */
    public $incrementing = true;

}
