<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Experts\ExpertProfile;
use App\Models\Users\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FavoritesController extends Controller {
    public function index() {
        $userId = Auth::id();
        $profiles = Favorite::getFavoriteAndExpertProfileInfo($userId)->get();
        foreach ($profiles as $profile) {
            $profile->tags = explode(',', $profile->tags);
            $profile->positions = explode(',', $profile->positions);
            $profile->activity_image = explode(',', $profile->activity_image)[0];
        }
        return Inertia::render('Users/Favorite/Index', [
             'profiles' => $profiles,
        ]);
    }

    public function switch(Request $request) {

        $validator = \Validator::make($request->all(), [
            'expert_id' => 'required|exists:experts,id'
        ]);

        if ($validator->fails()) {
            \Log::error('validation error');
            return;
        }

        $params = $validator->validated();

        $params['user_id'] = \Auth::id();

        $favorite = Favorite::getFavorite($params['expert_id'], $params['user_id'])->first();
        if (isset($favorite)) {
            $favorite->delete();
        } else {
           Favorite::create($params);
        }

        return Favorite::getUserFavorite($params['user_id'])->get();

    }


}
