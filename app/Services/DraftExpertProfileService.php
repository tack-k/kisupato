<?php

namespace App\Services;

use App\Models\Experts\DraftActivityImage;
use App\Models\Experts\ActivityImage;
use App\Models\Experts\DraftExpertProfile;
use App\Models\Experts\DraftSkill;
use App\Models\Experts\ExpertProfile;
use App\Models\Experts\Skill;
use App\Consts\CommonConst;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DraftExpertProfileService {
    //共通サービスクラス
    protected $_commonService;

    public function __construct() {
        $this->_commonService = new CommonService();
    }


    /**
     * プロフィール更新処理
     * @param $request
     * @param $expert_id
     */
    public function updateDraftExpertProfile($request, $expert_id) {

        DB::transaction(function () use ($request, $expert_id) {
            $params = $request->only([
                'status',
                'nickname',
                'profile_image',
                'self_introduction',
                'activity_title',
                'activity_content',
            ]);

            if ($request->has('delete_profile_image') && $request->delete_profile_image[0] !== 'default_profile.png') {
                $params['profile_image'] = 'default_profile.png';
                //ファイルの削除処理
                Storage::disk('public')->delete(CommonConst::PROFILE_PATH . $request->delete_profile_image[0]);
            }


            if ($request->has('profile_image')) {
                $profile_image = $request->file('profile_image')[0];
                $profile_image_name = $this->_commonService->imageNameFormat($profile_image);
                Storage::disk('public')->putFileAs(CommonConst::PROFILE_PATH, $profile_image, $profile_image_name);
                $params['profile_image'] = $profile_image_name;
            }

            if ($request->has('saved_profile_image')) {
                $params['profile_image'] = $request->saved_profile_image[0];
            }

            $profile = DraftExpertProfile::updateOrCreate(['expert_id' => $expert_id], $params);

            if ($request->has('delete_activity_images')) {
                //ファイルの削除
                foreach ($request->delete_activity_images as $delete_activity_image) {
                    $delete_activity_path[] = CommonConst::ACTIVITY_PATH . $delete_activity_image['activity_image'];
                    $activity_image_id[] = $delete_activity_image['id'];
                }
                Storage::disk('public')->delete($delete_activity_path);

                //パスの削除
                DraftActivityImage::destroy($activity_image_id);
                ActivityImage::destroy($activity_image_id);
            }

            $image = [];
            if ($request->has('activity_images')) {

                $activity_images = $request->file('activity_images');
                foreach ($activity_images as $activity_image) {
                    $activity_image_name = $this->_commonService->imageNameFormat($activity_image);
                    Storage::disk('public')->putFileAs(CommonConst::ACTIVITY_PATH, $activity_image, $activity_image_name);
                    $image[] = [
                        'id' => null,
                        'draft_expert_profile_id' => $profile->id,
                        'activity_image' => $activity_image_name
                    ];
                }
            }

            //本番保存された活動写真を一時保存に反映
            if ($request->has('saved_activity_images')) {
                $saved_activity_images = $request->saved_activity_images;
                foreach ($saved_activity_images as $saved_activity_image) {
                    $image[] = [
                        'id' => $saved_activity_image['id'],
                        'draft_expert_profile_id' => $profile->id,
                        'activity_image' => $saved_activity_image['activity_image']
                    ];
                }
            }

            DraftActivityImage::upsert($image, 'id', ['activity_image']);

            $delete_skills_id = $request->delete_skills;
            DraftSkill::destroy($delete_skills_id);
            Skill::destroy($delete_skills_id);

            $skills_params = $request->skills;
            foreach ($skills_params as $skills_param) {
                $skills_param['draft_expert_profile_id'] = $profile->id;
                $skills[] = $skills_param;
            }

            DraftSkill::upsert($skills, 'id', ['skill_title', 'skill_content']);

        });
    }

    /**
     * 一時保存した専門人材のプロフィールを削除
     * @param $expert_id
     */
    public function deleteDraftExpertInfo($expert_id) {
        $is_saved = DraftExpertProfile::checkTemporarilySaved($expert_id);
        if ($is_saved) {
            $draft_profile = DraftExpertProfile::getDraftExpertProfileAllInfo($expert_id)->first();
            $draft_profile_image = $draft_profile->profile_image;
            $is_same_image = ExpertProfile::checkSameImage($draft_profile_image);
            if (!$is_same_image) {
                Storage::disk('public')->delete(CommonConst::PROFILE_PATH . $draft_profile_image);
            }

            $draft_activity_images = $draft_profile->draftActivityImages;
            if ($draft_activity_images) {
                foreach ($draft_activity_images as $draft_activity_image) {
                  $image[] = $draft_activity_image['activity_image'];
                }
                $same_images = ActivityImage::whereIn('activity_image', $image)->get();

                if (!$same_images) {
                    Storage::disk('public')->delete(CommonConst::ACTIVITY_PATH . $same_images);
                }
            }


            $draft_profile_id = $draft_profile->id;
            DraftExpertProfile::destroy($draft_profile_id);
            DraftSkill::where('draft_expert_profile_id', $draft_profile_id)->delete();
            DraftActivityImage::where('draft_expert_profile_id', $draft_profile_id)->delete();
        }

    }
}
