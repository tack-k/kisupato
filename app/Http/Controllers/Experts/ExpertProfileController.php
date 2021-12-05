<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertProfileRequest;
use App\Models\Experts\ExpertProfile;
use App\Services\CommonService;
use App\Services\DraftExpertProfileService;
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

    //下書きエキスパートサービスクラス
    protected $_draftExpertProfileService;

    protected $_commonService;

    public function __construct()
    {
        $this->_service = new ExpertProfileService();
        $this->_draftExpertProfileService = new DraftExpertProfileService();
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

//        $is_saved = DraftExpertProfile::checkTemporarilySaved($expert_id);
//
//        if ($is_saved) {
//            $profile = DraftExpertProfile::getDraftExpertProfileInfo($expert_id)->first();
//            if ($profile) {
//                $skills = $profile->draftSkills()->select('id', 'skill_title', 'skill_content')->where('draft_expert_profile_id', $profile->id)->get();
//                $activity_images = $profile->draftActivityImages;
//            } else {
//                $profile = ['profile_image' => 'default_profile.png'];
//                $skills = [];
//                $activity_images = [];
//            }
//
//        } else {
//            $profile = ExpertProfile::getExpertProfileInfo($expert_id)->first();
//            if ($profile) {
//
//                $skills = $profile->skills()->select('id', 'skill_title', 'skill_content')->where('expert_profile_id', $profile->id)->get();
//                $activity_images = $profile->activityImages;
//            } else {
//                $profile = ['profile_image' => 'default_profile.png'];
//                $skills = [];
//                $activity_images = [];
//            }
//
//        }

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
        $validated = $request->validate([
            'status' => ['required', 'string', 'between:0,1']
        ]);

        $expert_id = Auth::guard('expert')->id();
        $profile = ExpertProfile::getExpertProfileAllInfo($expert_id)->first();

        $messages = [];

        if(is_null($profile->profile_image)) {
            $messages[] = 'プロフィール画像を入力してください';
        }

        if(is_null($profile->self_introduction)) {
            $messages[] = '自己紹介を入力してください';
        }

        if(is_null($profile->activity_title)) {
            $messages[] = '活動タイトルを入力してください';
        }

        if(is_null($profile->activity_content)) {
            $messages[] = '活動内容を入力してください';
        }

        if($profile->activityImages->isEmpty()) {
            $messages[] = '活動写真を入力してください';
        }

        foreach ($profile->skills as $key => $skill) {
            if(is_null($skill['skill_title'])) {
                $messages[] = '提供スキルタイトル' . ($key + 1) . 'を入力してください';
            }
            if(is_null($skill['skill_content'])) {
                $messages[] = '提供スキル内容' . ($key + 1) . 'を入力してください';
            }
        }

        $messages[] = 'プロフィールを公開しました。';

        return Redirect::route('expert.profile.show')->with('message', $messages);
    }


}

