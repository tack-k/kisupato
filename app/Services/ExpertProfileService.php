<?php

namespace App\Services;

use App\Consts\ExpertConst;
use App\Consts\MessageConst;
use App\Models\City;
use App\Models\Experts\ActivityImage;
use App\Models\Experts\ExpertProfile;
use App\Models\Experts\Skill;
use App\Consts\CommonConst;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ExpertProfileService
{

    //共通サービスクラス
    protected $_commonService;

    public function __construct()
    {
        $this->_commonService = new CommonService();
    }

    /**
     * 専門人材のプロフィール情報を更新する
     * @param $request
     * @param $expert_id
     */
    public function updateExpertProfile($request, $expert_id)
    {

        $params = $request->only([
            'status',
            'nickname',
            'profile_image',
            'self_introduction',
            'activity_title',
            'activity_content',
            'activity_base',
        ]);


        if ($request->has('delete_profile_image')) {
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


        $sameActivityBaseExist = ExpertProfile::where('expert_id', $expert_id)->where('activity_base', $params['activity_base'])->exists();
        if(!$sameActivityBaseExist && isset($params['activity_base'])) {
            $city = City::select('id', 'latitude', 'longitude')->where('id', $params['activity_base'])->first();
            $params['latitude'] = $city['latitude'] . $this->_commonService->generateRandomNumbers(4);
            $params['longitude'] = $city['longitude'] . $this->_commonService->generateRandomNumbers(4);
        }


        $profile = ExpertProfile::updateOrCreate(['expert_id' => $expert_id], $params);

        $tagIds = $request->only('tag');

        if ($tagIds) {
            $profile->tags()->sync($tagIds['tag']);
        }else {
            $profile->tags()->detach();
        }

        $positionId = $request->only('position');
        if ($positionId) {
            $profile->positions()->sync(array($positionId['position']));
        } else {
            $profile->positions()->detach();
        }

        if ($request->has('delete_activity_images')) {
            //ファイルの削除
            foreach ($request->delete_activity_images as $delete_activity_image) {
                $delete_activity_path[] = CommonConst::ACTIVITY_PATH . $delete_activity_image['activity_image'];
                $activity_image_id[] = $delete_activity_image['id'];
            }

            Storage::disk('public')->delete($delete_activity_path);

            //パスの削除
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
                    'expert_profile_id' => $profile->id,
                    'activity_image' => $activity_image_name
                ];
            }
        }

        if ($request->has('saved_activity_images')) {
            $saved_activity_images = $request->saved_activity_images;
            foreach ($saved_activity_images as $saved_activity_image) {

                $image[] = [
                    'id' => $saved_activity_image['id'],
                    'expert_profile_id' => $profile->id,
                    'activity_image' => $saved_activity_image['activity_image']
                ];

                $saved_images[] = $saved_activity_image['activity_image'];
            }

        }

        ActivityImage::upsert($image, 'id', ['activity_image']);


        $delete_skills_id = $request->delete_skills;
        Skill::destroy($delete_skills_id);

        if ($request->has('skills')) {
            $skills_params = $request->skills;
            $skills = [];
            foreach ($skills_params as $skills_param) {
                $skills['id'] = $skills_param['id'] ?? null;
                $skills['skill_title'] = $skills_param['skill_title'];
                $skills['skill_content'] = $skills_param['skill_content'];
                $skills['expert_profile_id'] = $profile->id;
            }

            Skill::upsert($skills, 'id', ['skill_title', 'skill_content']);
        }

    }

    /**
     * プロフィールの存在をチェックしてエラーメッセージを返す
     * @param $profile
     * @param $messages
     * @return mixed
     */
    public function checkProfileExistence($profile, $messages)
    {

        if (is_null($profile->nickname)) {
            $messages[] = MessageConst::NICKNAME . MessageConst::E_00004;
        }

        if (is_null($profile->profile_image)) {
            $messages[] = MessageConst::PROFILE_IMAGE . MessageConst::E_00004;
        }

        if (is_null($profile->self_introduction)) {
            $messages[] = MessageConst::SELF_INTRODUCTION . MessageConst::E_00004;
        }

        if (is_null($profile->activity_title)) {
            $messages[] = MessageConst::ACTIVITY_TITLE . MessageConst::E_00004;
        }

        if (is_null($profile->activity_content)) {
            $messages[] = MessageConst::ACTIVITY_CONTENT . MessageConst::E_00004;
        }

        if ($profile->activityImages->isEmpty()) {
            $messages[] = MessageConst::ACTIVITY_IMAGE . MessageConst::E_00004;
        }

        foreach ($profile->skills as $key => $skill) {
            if (is_null($skill['skill_title'])) {
                $messages[] = MessageConst::SKILL_TITLE . ($key + 1) . MessageConst::E_00004;
            }
            if (is_null($skill['skill_content'])) {
                $messages[] = MessageConst::SKILL_CONTENT . ($key + 1) . MessageConst::E_00004;
            }
        }

        if(is_null($profile->activity_base)) {
            $messages[] = MessageConst::ACTIVITY_BASE . MessageConst::E_00004;
        }

        if($profile->tags->isEmpty()) {
            $messages[] = MessageConst::TAGS . MessageConst::E_00004;
        }

        if($profile->positions->isEmpty()) {
            $messages[] = MessageConst::POSITIONS . MessageConst::E_00004;
        }

        return $messages;

    }


    public function formatExpertProfile($profile)
    {
        $formatProfile['tags'] = $this->_commonService->changeStingToArray($profile['tags']);
        $formatProfile['positions'] = $this->_commonService->changeStingToArray($profile['positions']);
        //カルーセル作成まで暫定的に一番最初の画像だけを設定する
        $formatProfile['activity_image'] = $this->_commonService->changeStingToArray($profile['activity_image'])[0];
        if (mb_strlen($profile['activity_content']) > CommonConst::MAX_ACTIVITY_CONTENT_COUNT) {
            $formatProfile['activity_content'] = $this->_commonService->limitNumberOfCharacters($profile['activity_content'], CommonConst::MAX_ACTIVITY_CONTENT_COUNT);
        }
        if (mb_strlen($profile['activity_title']) > CommonConst::MAX_ACTIVITY_TITLE_COUNT) {
            $formatProfile['activity_title'] = $this->_commonService->limitNumberOfCharacters($profile['activity_title'], CommonConst::MAX_ACTIVITY_TITLE_COUNT);
        }

        return $formatProfile;

    }

}
