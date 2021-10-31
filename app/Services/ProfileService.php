<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function saveParams($request, $params) {
        $image = $request->file('image');

        $profile_image_name = Carbon::now()->format('Ymd_') . rand();
        $profile_image_extension = '.' . $image->getClientOriginalExtension();
        $activity_image_path = "/storage/profile_images/{$profile_image_name}";

        $params['profile_image'] = [
         'profile_image_path' =>  $activity_image_path,
         'profile_image_extension' =>  $profile_image_extension,
        ];

        Storage::disk('public')->putFileAs('profile_images', $image, $profile_image_name . $profile_image_extension);

        $activity_images = $request->file('activity_images');

        $params['activity_images'] = [];
        foreach ($activity_images as $activity_image) {
            $activity_image_name = Carbon::now()->format('Ymd_') . rand();
            $activity_image_extension = '.' . $activity_image->getClientOriginalExtension();
            $activity_image_path = "/storage/activity_images/{$activity_image_name}";

            array_push($params['activity_images'], [
                'activity_image_path' => $activity_image_path,
                'activity_image_extension' => $activity_image_extension,
            ]);
            Storage::disk('public')->putFileAs('activity_images', $activity_image, $activity_image_name . $activity_image_extension);
        }

        session(['input_profile' => $params]);
    }
}
