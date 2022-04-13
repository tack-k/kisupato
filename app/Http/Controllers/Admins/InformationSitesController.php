<?php

namespace App\Http\Controllers\Admins;

use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\InformationSiteRequest;
use App\Models\Admins\InformationSite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InformationSitesController extends Controller {


    public function create() {
        return Inertia::render('Admins/InformationSite/Create');
    }

    public function update(InformationSiteRequest $request) {
        $params = $request->all();

        InformationSite::updateOrCreate(['id' => $params['id']], $params);
        session()->flash('message', MessageConst::INFORMATION_SITE . MessageConst::I_REGISTER);
    }

}
