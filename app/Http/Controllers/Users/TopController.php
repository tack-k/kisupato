<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Admins\Tag;
use App\Models\Experts\ExpertProfile;
use App\Services\ExpertProfileService;
use App\Services\TopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Testing\Assert;

class TopController extends Controller {
    //トップサービスクラス
    protected $_service;

    protected $_expertProfileService;

    public function __construct()
    {
        $this->_service = new TopService();
        $this->_expertProfileService = new ExpertProfileService();
    }

    public function index()
    {

        $expertProfile = new ExpertProfile();
        $areas = $expertProfile->getAreas();
        $areaAndCities = $expertProfile->getAreaAndCities();

        $formatAreaData = $this->_service->formatAreaData($areas, $areaAndCities);

        $tags = Tag::getTags()->get();

        $profiles = ExpertProfile::getExpertProfileCardInfo()->get() ?? null;

        foreach ($profiles as $profile) {
            $formatProfile = $this->_expertProfileService->formatExpertProfile($profile);
            $profile->activity_image = $formatProfile['activity_image'];
            $profile->tags = $formatProfile['tags'];
            $profile->positions = $formatProfile['positions'];
            $profile->activity_content = $formatProfile['activity_content'];
            $profile->activity_title = $formatProfile['activity_title'];
        }

        return Inertia::render('Users/Top/Index', [
            'areas' => $formatAreaData,
            'tags' => $tags,
            'profiles' => $profiles,
        ]);
    }
}
