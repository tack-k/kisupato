<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Experts\ExpertProfile;
use App\Models\Users\Favorite;
use App\Services\ExpertProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FavoritesController extends Controller {

    protected $_expertProfileService;

    public function __construct()
    {
        $this->_expertProfileService = new ExpertProfileService();
    }

    public function index() {
        $userId = Auth::id();
        $profiles = Favorite::getFavoriteAndExpertProfileInfo($userId)->get();


        foreach ($profiles as $profile) {
            $formatProfile = $this->_expertProfileService->formatExpertProfile($profile);
            $profile->activity_image = $formatProfile['activity_image'];
            $profile->tags = $formatProfile['tags'];
            $profile->positions = $formatProfile['positions'];
            $profile->activity_content = $formatProfile['activity_content'];
            $profile->activity_title = $formatProfile['activity_title'];
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

    public function delete(Request $request) {

        $params = $request->validate([
            'id' => 'required|exists:favorites'
        ]);

        Favorite::destroy($params['id']);


    }


}
