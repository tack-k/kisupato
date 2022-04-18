<?php

namespace App\Http\Controllers\Admins;

use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\InformationSiteRequest;
use App\Models\Admins\InformationSite;
use App\Services\InformationSiteService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InformationSitesController extends Controller {

    protected $_service;

    public function __construct() {
        $this->_service = new InformationSiteService();
    }

    public function index(Request $request) {
        $keyword = $request->input('keyword');
        $informationSites = InformationSite::getSearchedInformationSites($keyword);
        foreach ($informationSites as $informationSite) {
            $informationSite['status_name'] = $this->_service->formatInformationSiteStatus($informationSite['status']);
        }

        return Inertia::render('Admins/InformationSite/Index', [
           'informationSites' => $informationSites,
        ]);
    }

    public function create() {
        return Inertia::render('Admins/InformationSite/Create');
    }

    public function update(InformationSiteRequest $request) {
        $params = $request->all();

        InformationSite::updateOrCreate(['id' => $params['id']], $params);
        session()->flash('message', MessageConst::INFORMATION_SITE . MessageConst::I_REGISTER);

        return redirect()->route('admin.information_site.index');
    }

    public function edit($informationSiteId) {

        $informationSite = InformationSite::getInformationSite($informationSiteId)->first();
        return Inertia::render('Admins/InformationSite/Edit', [
           'informationSite' => $informationSite,
        ]);
    }

}
