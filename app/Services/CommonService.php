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
        return Carbon::now()->format('Ymd_') . $this->generateRandomNumbers(8) . '.' . $image->getClientOriginalExtension();
    }

    /**
     * ゼロを含む乱数を生成する（ex:0893）
     * @param int $length
     * @return string
     */
    public function generateRandomNumbers(int $length) :string
    {
        $max = pow(10, $length) - 1;
        $rand = mt_rand(0, $max);
        return sprintf('%0'. $length. 'd', $rand);

    }

    /**
     * コンマで繋がれた文字列を配列に変換する
     * @param $activityImage
     * @return false|string[]
     */
    public function changeStingToArray($activityImage)
    {
        return explode(',', $activityImage);
    }

    /**
     * 表示する文字数を制限する
     * @param $string
     * @param $limitCount
     * @return string
     */
    public function limitNumberOfCharacters($string, $limitCount) {
        return mb_substr($string, 1, $limitCount) . '...';
    }
}
