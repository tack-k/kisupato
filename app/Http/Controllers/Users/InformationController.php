<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Admins\InformationSite;
use Inertia\Inertia;

class InformationController extends Controller {
    public function index() {

        $informationSites =  InformationSite::getPublicInformationSites()->get();

        return Inertia::render('Users/Information/Index', [
            'informationSites' => $informationSites,
        ]);
    }

    public function show($informationSiteId) {
        $informationSite = InformationSite::getInformationSite($informationSiteId)->first();

        return Inertia::render('Users/Information/Show', [
           'informationSite' => $informationSite,
        ]);
    }
}
