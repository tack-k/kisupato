<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertProfileRequest;
use App\Models\Experts\ExpertProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Services\ExpertProfileService;

class ExpertProfileController extends Controller {
    //プロフィールサービスクラス
    protected $_service;

    public function __construct() {
        $this->_service = new ExpertProfileService();
    }

    public function show() {
        return Inertia::render('Experts/Profile/Show');
    }

    public function input() {

        $expert_id = Auth::guard('expert')->id();
        $profile = ExpertProfile::select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content')
            ->firstWhere('expert_id', $expert_id);

        if ($profile) {
            $skills = $profile->skills()->select('id', 'skill_title', 'skill_content')->where('expert_profile_id', $profile->id)->get();
            $activity_images = $profile->activityImages;
        } else {
            $profile = ['profile_image' => 'default_profile.png'];
            $skills = [];
            $activity_images = [];
        }

        return Inertia::render(('Experts/Profile/Input'), [
            'profile' => $profile,
            'skills' => $skills,
            'activityImages' => $activity_images,
        ]);
    }

    public function update(ExpertProfileRequest $request) {

        //プロフィール更新処理
        $this->_service->updateProfile($request);

        return Redirect::route('expert.profile.show');
    }

}

