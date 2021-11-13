<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftExpertProfileRequest;
use App\Http\Requests\ExpertProfileRequest;
use App\Models\Experts\DraftExpertProfile;
use App\Models\Experts\ExpertProfile;
use App\Services\DraftExpertProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Services\ExpertProfileService;

class ExpertProfileController extends Controller {
    //プロフィールサービスクラス
    protected $_service;

    public function __construct() {
        $this->_service = new ExpertProfileService();
        $this->_draftExpertProfileService = new DraftExpertProfileService();
    }

    public function show() {
        return Inertia::render('Experts/Profile/Show');
    }

    public function input() {
        $expert_id = Auth::guard('expert')->id();
        $profile = DraftExpertProfile::select('saved_flag')->firstWhere('expert_id', $expert_id);

        if($profile->saved_flag == 0) {
            $profile = DraftExpertProfile::select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content', 'saved_flag')
                ->firstWhere('expert_id', $expert_id);
            if ($profile) {
                $skills = $profile->draftSkills()->select('id', 'skill_title', 'skill_content')->where('draft_expert_profile_id', $profile->id)->get();
                $activity_images = $profile->draftActivityImages;
            } else {
                $profile = ['profile_image' => 'default_profile.png'];
                $skills = [];
                $activity_images = [];
            }
        }else {
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
        }

        return Inertia::render(('Experts/Profile/Input'), [
            'profile' => $profile,
            'skills' => $skills,
            'activityImages' => $activity_images,
        ]);
    }

    public function update(ExpertProfileRequest $request) {
        $expert_id = Auth::guard('expert')->id();
        if($request->saved_flag == 0) {
          $this->_draftExpertProfileService->updateDraftExpertProfile($request, $expert_id);
            return Redirect::route('expert.profile.input');

        }else {
            //プロフィール更新処理
            $this->_service->updateExpertProfile($request, $expert_id);

            //保存状態を解除
            DraftExpertProfile::where('expert_id', $expert_id)
            ->update(['saved_flag' => $request->saved_flag]);
        }


        return Redirect::route('expert.profile.show');
    }

    public function updateDraft(DraftExpertProfileRequest $request) {
        $this->_draftExpertProfileService->updateDraftExpertProfile($request);

        $expert_id = Auth::guard('expert')->id();
        $profile = DraftExpertProfile::select('id', 'expert_id', 'status', 'nickname', 'profile_image', 'self_introduction', 'activity_title', 'activity_content', 'saved_flag')
            ->firstWhere('expert_id', $expert_id);
        if ($profile) {
            $skills = $profile->draftSkills()->select('id', 'skill_title', 'skill_content')->where('draft_expert_profile_id', $profile->id)->get();
            $activity_images = $profile->draftActivityImages;

        } else {
            $profile = ['profile_image' => 'default_profile.png'];
            $skills = [];
            $activity_images = [];
        }

       return [
           'profile' => $profile,
           'skills' => $skills,
           'activity_images' => $activity_images,
       ];

    }

}

