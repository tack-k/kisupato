<?php

namespace App\Http\Controllers\Admins;

use App\Consts\AdminConst;
use App\Consts\CommonConst;
use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\InformationSiteRequest;
use App\Models\Admins\InformationSite;
use App\Services\CommonService;
use App\Services\InformationSiteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;


class InformationSitesController extends Controller {

    protected $_service;
    protected $_commonService;


    public function __construct() {
        $this->_service = new InformationSiteService();
        $this->_commonService = new CommonService();

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

    public function create(Request $request) {
        $referer = $request->header('referer');
        $informationSite = null;
        if (strpos($referer, 'information_site/confirm')) {
            $informationSite = session()->get(CommonConst::SK_INFORMATION_SITE);
        }
        session()->forget(CommonConst::SK_INFORMATION_SITE);
        return Inertia::render('Admins/InformationSite/Create', [
            'informationSite' => $informationSite,
        ]);
    }

    public function update(InformationSiteRequest $request) {
        $params = $request->all();

        if ($params['status'] === AdminConst::INFORMATION_SITE_PUBLIC) {
            $params['posted_at'] = Carbon::now();
        }

        InformationSite::updateOrCreate(['id' => $params['id']], $params);
        session()->flash('message', MessageConst::INFORMATION_SITE . MessageConst::I_REGISTER);

        return redirect()->route('admin.information_site.index');
    }

    public function edit(Request $request, $informationSiteId) {
        $referer = $request->header('referer');
        $informationSite = null;
        if (strpos($referer, 'information_site/confirm')) {
            $informationSite = session()->get(CommonConst::SK_INFORMATION_SITE);
        }
        session()->forget(CommonConst::SK_INFORMATION_SITE);

        if (is_null($informationSite)) {
            $informationSite = InformationSite::getInformationSite($informationSiteId)->first();
        }

        return Inertia::render('Admins/InformationSite/Edit', [
            'informationSite' => $informationSite,
        ]);
    }

    public function delete(Request $request) {

        $ids = $request->input('checked');
        $page = $request->input('page');
        $keyword = $request->input('keyword');

        $adminId = $this->_commonService->getAdminId();

        DB::transaction(function () use ($ids, $adminId) {
            InformationSite::whereIn('id', $ids)->update(['deleted_by' => MessageConst::ADMIN_BY . $adminId]);
            InformationSite::destroy($ids);
            session()->flash('message', MessageConst::INFORMATION_SITE . MessageConst::I_DELETED);
        });

        return Inertia::location(route('admin.information_site.index', ['page' => $page, 'keyword' => $keyword]));
    }

    public function confirm(InformationSiteRequest $request) {

        $informationSite = $request->all();
        $referer = $request->header('referer');
        $link = strpos($referer, 'create') !== false ? 'create' : 'edit';

        $informationSite['status_name'] = $this->_service->formatInformationSiteStatus($informationSite['status']);

        session([CommonConst::SK_INFORMATION_SITE => $informationSite]);

        return Inertia::render('Admins/InformationSite/Confirm', [
            'informationSite' => $informationSite,
            'link' => $link,
        ]);
    }

    public function finish(InformationSiteRequest $request) {
        $params = session()->get(CommonConst::SK_INFORMATION_SITE);

        if (is_null($params)) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        if ($params['status'] === AdminConst::INFORMATION_SITE_PUBLIC) {
            $params['posted_at'] = Carbon::now();
        }

        InformationSite::updateOrCreate(['id' => $params['id']], $params);
        session()->flash('message', MessageConst::INFORMATION_SITE . MessageConst::I_REGISTER);
        session()->forget(CommonConst::SK_INFORMATION_SITE);

        return redirect()->route('admin.information_site.index');
    }

}
