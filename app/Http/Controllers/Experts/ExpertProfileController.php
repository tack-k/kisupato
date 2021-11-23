<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftExpertProfileRequest;
use App\Http\Requests\ExpertProfileRequest;
use App\Models\Experts\DraftExpertProfile;
use App\Models\Experts\ExpertProfile;
use App\Services\CommonService;
use App\Services\DraftExpertProfileService;
use App\Consts\ExpertConst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Services\ExpertProfileService;

class ExpertProfileController extends Controller {
    //プロフィールサービスクラス
    protected $_service;

    //下書きエキスパートサービスクラス
    protected $_draftExpertProfileService;

    protected $_commonService;

    public function __construct() {
        $this->_service = new ExpertProfileService();
        $this->_draftExpertProfileService = new DraftExpertProfileService();
        $this->_commonService = new CommonService();

    }

    /**
     * 専門人材の現在のプロフィール情報を表示する
     * @return \Inertia\Response
     */
    public function show() {
        $expert_id = Auth::guard('expert')->id();
        $profile = ExpertProfile::getExpertProfileAllInfo($expert_id)->first();

        if(is_null($profile)) {
            $saved = DraftExpertProfile::checkTemporarilySaved($expert_id);
            $saved = $saved ? ExpertConst::SAVED : ExpertConst::NOT_SAVED;

            return Redirect::route('expert.profile.input', ['saved' => $saved]);
        }

        return Inertia::render('Experts/Profile/Show', [
            'profile' => $profile,
        ]);
    }

    /**
     * 専門人材のプロフィール入力画面を表示する
     * @return \Inertia\Response
     */
    public function input() {

        $expert_id = Auth::guard('expert')->id();

        $is_saved = DraftExpertProfile::checkTemporarilySaved($expert_id);

        if ($is_saved) {
            $profile = DraftExpertProfile::getDraftExpertProfileInfo($expert_id)->first();
            if ($profile) {
                $skills = $profile->draftSkills()->select('id', 'skill_title', 'skill_content')->where('draft_expert_profile_id', $profile->id)->get();
                $activity_images = $profile->draftActivityImages;
            } else {
                $profile = ['profile_image' => 'default_profile.png'];
                $skills = [];
                $activity_images = [];
            }

        } else {
            $profile = ExpertProfile::getExpertProfileInfo($expert_id)->first();
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

    /**
     * 専門人材のプロフィール情報を更新する
     * @param ExpertProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExpertProfileRequest $request) {
        $expert_id = Auth::guard('expert')->id();

        DB::transaction(function () use ($request, $expert_id) {
            //プロフィール更新処理
            $this->_service->updateExpertProfile($request, $expert_id);

            //一時保存情報の削除
            $this->_draftExpertProfileService->deleteDraftExpertInfo($expert_id);

        });

        return Redirect::route('expert.profile.show');
    }

    /**
     * 専門人材のプロフィール一時保存情報を更新する
     * @param DraftExpertProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDraft(DraftExpertProfileRequest $request) {
     //   $expert_id = Auth::guard('expert')->id();

    //    $this->_draftExpertProfileService->updateDraftExpertProfile($request, $expert_id);
    }

    public function ajaxGetSaved() {
        $expert_id = Auth::guard('expert')->id();

        return DraftExpertProfile::checkTemporarilySaved($expert_id);

    }

}

