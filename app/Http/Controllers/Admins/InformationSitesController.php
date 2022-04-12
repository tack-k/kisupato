<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admins\InformationSite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InformationSitesController extends Controller {


    public function create() {
        return Inertia::render('Admins/InformationSite/Create');
    }

}
