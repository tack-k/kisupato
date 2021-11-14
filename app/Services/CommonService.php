<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CommonService {

    /**
     * 画像名を年月日+乱数にフォーマット
     * @param $image
     * @return string
     */
    public function imageNameFormat($image): string {
        return Carbon::now()->format('Ymd_') . mt_rand() . '.' . $image->getClientOriginalExtension();
    }
}
