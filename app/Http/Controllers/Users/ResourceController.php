<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Experts\ExpertProfile;
use App\Models\Users\ExpertReview;
use App\Services\CommonService;
use App\Services\ExpertProfileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResourceController extends Controller {

    protected $_service;

    protected $_commonService;

    public function __construct() {
        $this->_service = new ExpertProfileService();
        $this->_commonService = new CommonService();

    }

    public function index(Request $request) {

        $checked = $request->query('checked');
        $tag = $request->query('tag');
        $keyword = $request->query('keyword');

        $profilesInfo = $this->_service->getExpertProfiles($checked, $tag, $keyword);
        $profiles = $profilesInfo['profiles'];
        $messages = $profilesInfo['messages'];

        if($profiles->isEmpty()) {
            return Inertia::render('Users/Resource/Index', [
                'messages' => $messages,
                'profiles' => $profiles,
            ]);
        }

        foreach ($profiles as $profile) {
            $formatProfile = $this->_service->formatExpertProfile($profile);
            $profile->activity_image = $formatProfile['activity_image'];
            // TODO タグ検索の際に、そのタグのみが表示されるため暫定的な処置、クエリが複数回投げられるため要修正
            if (isset($tag)) {
                $expertTags = ExpertProfile::find($profile['expert_profile_id'])->tags()->get()->toArray();
                $setTags = [];
                foreach ($expertTags as $expertTag) {
                    $setTags[] = $expertTag['name'];
                }
                $profile->tags = $setTags;
            } else {
                $profile->tags = $formatProfile['tags'];
            }
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

        $profile = ExpertProfile::getExpertProfileCard()->where('expert_profiles.id', $params['id'])->first();
        $formatProfile = $this->_service->formatExpertProfile($profile);
        $profile->activity_image = $formatProfile['activity_image'];
        $profile->tags = $formatProfile['tags'];
        $profile->positions = $formatProfile['positions'];
        $profile->activity_content = $formatProfile['activity_content'];
        $profile->activity_title = $formatProfile['activity_title'];

        return $profile;

    }

    public function show(Request $request, $expert_id) {

        $expertProfile = ExpertProfile::getExpertProfileInfo($expert_id)->where('expert_profiles.status', '0')->first();

        if (is_null($expertProfile)) {
            return redirect(route('home'));
        }

        $expertReviews = ExpertReview::getExpertReviews($expert_id)->get();
        foreach ($expertReviews as $expertReview) {
            $expertReview['created_date'] = $this->_commonService->formatDate($expertReview['created_at']);
        }

        return Inertia::render('Users/Resource/Show', [
            'profile' => $expertProfile,
            'reviews' => $expertReviews,
        ]);
    }

}
