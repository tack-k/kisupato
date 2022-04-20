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
}
