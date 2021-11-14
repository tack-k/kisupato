<?php

namespace App\Services;

use App\Models\Experts\ActivityImage;
use App\Models\Experts\DraftExpertProfile;
use App\Models\Experts\ExpertProfile;
use App\Models\Experts\Skill;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExpertProfileService
{
    //プロフィール画像のパス
    protected $PROFILE_PATH = 'profile_images/';

    //活動写真のパス
    protected $ACTIVITY_PATH = 'activity_images/';

    /**
     * プロフィール更新処理
     * @param $request
     */
    public function updateExpertProfile($request, $expert_id) {

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

                //ファイルの削除処理
                Storage::disk('public')->delete($this->PROFILE_PATH . $request->delete_profile_image[0]);
            }


            if ($request->has('profile_image')) {
                $profile_image = $request->file('profile_image')[0];
                $profile_image_name = $this->imageNameFormat($profile_image);
                Storage::disk('public')->putFileAs($this->PROFILE_PATH, $profile_image, $profile_image_name);
                $params['profile_image'] = $profile_image_name;
            }

            if ($request->has('saved_profile_image')) {
                $params['profile_image'] = $request->saved_profile_image[0];
            }

            $profile = ExpertProfile::updateOrCreate(['expert_id' => $expert_id], $params);

            if ($request->has('delete_activity_images')) {
                //ファイルの削除
                foreach ($request->delete_activity_images as $delete_activity_image) {
                    $delete_activity_path[] = $this->ACTIVITY_PATH . $delete_activity_image['activity_image'];
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
                    $activity_image_name = $this->imageNameFormat($activity_image);
                    Storage::disk('public')->putFileAs($this->ACTIVITY_PATH, $activity_image, $activity_image_name);
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
                }
            }
                ActivityImage::upsert($image, 'id', ['activity_image']);


            $delete_skills_id = $request->delete_skills;
            Skill::destroy($delete_skills_id);

            $skills_params = $request->skills;
            foreach ($skills_params as $skills_param) {
                $skills_param['expert_profile_id'] = $profile->id;
                $skills[] = $skills_param;
            }

            Skill::upsert($skills, 'id', ['skill_title', 'skill_content']);

            DraftExpertProfile::where('expert_id', $expert_id)
                ->update(['saved_flag' => false]);

        });
    }

    /**
     * 画像名を年月日+乱数にフォーマット
     * @param $image
     * @return string
     */
    public function imageNameFormat($image): string {
        return Carbon::now()->format('Ymd_') . mt_rand() . '.' . $image->getClientOriginalExtension();
    }
}
