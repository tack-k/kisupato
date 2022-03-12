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
use Illuminate\Support\Facades\Redirect;
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

    public function show()
    {
        $userId = Auth::id();
        $profile = UserProfile::getUserProfile($userId)->first();
        if (is_null($profile)) {
            return Redirect::route('profile.input');
        }

        return Inertia::render('Users/UserProfile/Show', [
            'profile' => $profile,
        ]);
    }

    public function input()
    {
        $userId = Auth::id();
        $profile = UserProfile::getUserProfile($userId)->first();

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

        return redirect()->route('profile.show');

    }


}
