<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Admins\Tag;
use App\Models\Experts\ExpertProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResourceController extends Controller
{
    public function index() {

        $profiles = ExpertProfile::getExpertProfileCardInfo()->addSelect(['longitude', 'latitude'])->get();
        foreach ($profiles as $profile) {
            $profile->activity_image = explode(',', $profile->activity_image);
            //カルーセル作成まで暫定的に一番最初の画像だけを設定する
            $profile->activity_image = $profile->activity_image[0];
        }

       return Inertia::render('Users/Resource/Index', [
           'profiles' => $profiles,
       ]);
    }

    public function card(Request $request) {
        $params = $request->validate([
            'id' => 'exists:expert_profiles'
        ]);

        $profile = ExpertProfile::getExpertProfileCardInfo()->where('expert_profiles.id', $params['id'])->first();
        $profile->activity_image = explode(',', $profile->activity_image);
        //カルーセル作成まで暫定的に一番最初の画像だけを設定する
        $profile->activity_image = $profile->activity_image[0];

        return $profile;

    }
}
