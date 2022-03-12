<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Models\Users\UserProfile;
use App\Services\CommonService;
use App\Services\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserProfilesController extends Controller {

    //プロフィールサービスクラス
    protected $_service;

    protected $_commonService;

    public function __construct()
    {
        $this->_service = new  UserProfileService();
        $this->_commonService = new CommonService();

    }

    public function show(UserProfile $userProfile)
    {
        //
    }

    public function input()
    {
        $userId = Auth::id();
        $profile = UserProfile::getUserProfile($userId)->first();
        if (!$profile) {
            $profile = ['profile_image' => 'default_profile.png'];
        }
        return Inertia::render('Users/UserProfile/Input', [
            'profile' => $profile,
        ]);
    }

    public function update(UserProfileRequest $request)
    {
        $userId = \Auth::id();
        DB::transaction(function () use ($request, $userId) {
            //プロフィール更新処理
            $this->_service->updateUserProfile($request, $userId);
        });

        return redirect()->route('profile.input');

    }

}
