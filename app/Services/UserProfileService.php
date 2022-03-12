<?php

namespace App\Services;

use App\Consts\CommonConst;
use App\Consts\UserConst;
use App\Models\Users\UserProfile;
use Illuminate\Support\Facades\Storage;

class UserProfileService {

    //共通サービスクラス
    protected $_commonService;

    public function __construct()
    {
        $this->_commonService = new CommonService();
    }

    public function updateUserProfile($request, $userId)
    {

        $params = $request->only([
            'nickname',
            'profile_image',
            'self_introduction',
        ]);

        if ($request->has('delete_profile_image')) {
            //ファイルの削除処理
            Storage::disk('public')->delete(CommonConst::USER_PROFILE_PATH . $request->delete_profile_image[0]);
        }

        if ($request->has('profile_image')) {
            $profile_image = $request->file('profile_image')[0];
            $profile_image_name = $this->_commonService->imageNameFormat($profile_image);
            Storage::disk('public')->putFileAs(CommonConst::USER_PROFILE_PATH, $profile_image, $profile_image_name);
            $params['profile_image'] = $profile_image_name;
        }

        if ($request->has('saved_profile_image')) {
            $params['profile_image'] = $request->saved_profile_image[0];
        }

         UserProfile::updateOrCreate(['user_id' => $userId], $params);
    }

}
