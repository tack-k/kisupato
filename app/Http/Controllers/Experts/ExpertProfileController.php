<?php

namespace App\Http\Controllers\Experts;

use App\Consts\ExpertConst;
use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertProfileRequest;
use App\Models\Experts\ExpertProfile;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Services\ExpertProfileService;

class ExpertProfileController extends Controller
{
    //プロフィールサービスクラス
    protected $_service;

    protected $_commonService;

    public function __construct()
    {
        $this->_service = new ExpertProfileService();
        $this->_commonService = new CommonService();

    }

    /**
     * 専門人材の現在のプロフィール情報を表示する
     * @return \Inertia\Response
     */
    public function show()
    {
        $expert_id = Auth::guard('expert')->id();
        $profile = ExpertProfile::getExpertProfileAllInfo($expert_id)->first();

        if (is_null($profile)) {
            return Redirect::route('expert.profile.input');
        }

        return Inertia::render('Experts/Profile/Show', [
            'profile' => $profile,
        ]);
    }

    /**
     * 専門人材のプロフィール入力画面を表示する
     * @return \Inertia\Response
     */
    public function input()
    {

        $expert_id = Auth::guard('expert')->id();

        $profile = ExpertProfile::getExpertProfileInfo($expert_id)->first();
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

    /**
     * 専門人材のプロフィール情報を更新する
     * @param ExpertProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExpertProfileRequest $request)
    {
        $expert_id = Auth::guard('expert')->id();

        DB::transaction(function () use ($request, $expert_id) {
            //プロフィール更新処理
            $this->_service->updateExpertProfile($request, $expert_id);

        });

        return Redirect::route('expert.profile.show');
    }

    public function status(Request $request)
    {
        $params = $request->validate([
            'status' => ['required', 'string', 'between:0,1']
        ]);
        $expert_id = Auth::guard('expert')->id();
        $profile = ExpertProfile::getExpertProfileAllInfo($expert_id)->first();

        $messages = [];
        if ($params['status'] === ExpertConst::PUBLIC) {
           $messages = $this->_service->checkProfileExistence($profile, $messages);

            if ($messages) {
                return Redirect::route('expert.profile.show')->with('message', $messages);
            }
        }

        $profile->status = $params['status'];
        $profile->save();

        if ($profile->status === ExpertConst::PUBLIC) {
            $messages[] = MessageConst::PROFILE . MessageConst::I_00004;
        } else {
            $messages[] = MessageConst::PROFILE . MessageConst::I_00005;
        }

        return Redirect::route('expert.profile.show')->with('message', $messages);
    }


}

