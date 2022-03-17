<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Admins\Tag;
use App\Models\Experts\ExpertProfile;
use App\Services\ExpertProfileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResourceController extends Controller
{

    protected $_expertProfileService;

    public function __construct()
    {
        $this->_expertProfileService = new ExpertProfileService();
    }

    public function index() {

        $profiles = ExpertProfile::getExpertProfileCardInfo()->addSelect(['longitude', 'latitude'])->get();

        foreach ($profiles as $profile) {
            $formatProfile = $this->_expertProfileService->formatExpertProfile($profile);
            $profile->activity_image = $formatProfile['activity_image'];
            $profile->tags = $formatProfile['tags'];
            $profile->positions = $formatProfile['positions'];
            $profile->activity_content = $formatProfile['activity_content'];
            $profile->activity_title = $formatProfile['activity_title'];
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
        $formatProfile = $this->_expertProfileService->formatExpertProfile($profile);
        $profile->activity_image = $formatProfile['activity_image'];
        $profile->tags = $formatProfile['tags'];
        $profile->positions = $formatProfile['positions'];
        $profile->activity_content = $formatProfile['activity_content'];
        $profile->activity_title = $formatProfile['activity_title'];

        return $profile;

    }

    public function show(Request $request, $expert_id) {

        $expertProfile = ExpertProfile::getExpertProfileInfo($expert_id)->where('expert_profiles.status', '0')->first();

        if(is_null($expertProfile)) {
            return redirect(route('home'));
        }

        return Inertia::render('Users/Resource/Show', [
            'profile' => $expertProfile,
        ]);
    }

}
