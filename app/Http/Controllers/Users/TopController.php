<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Admins\Tag;
use App\Models\Experts\ExpertProfile;
use App\Services\TopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Testing\Assert;

class TopController extends Controller
{
    //トップサービスクラス
    protected $_service;

    public function __construct() {
        $this->_service = new TopService();
    }

    public function index()
    {

        $expertProfile = new ExpertProfile();
        $areas = $expertProfile->getAreas();
        $areaAndCities = $expertProfile->getAreaAndCities();

        $formatAreaData = $this->_service->formatAreaData($areas, $areaAndCities);

        $tags = Tag::getTags()->get();

        return Inertia::render('Users/Top/Index', [
            'areas' => $formatAreaData,
            'tags' => $tags,
        ]);
    }
}
