<?php

namespace App\Http\Controllers\Admins;

use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertContactTitleRequest;
use App\Models\Admins\ExpertContactTitle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ExpertContactTitleController extends Controller
{
    /**
     * 専門人材問い合わせ項目一覧画面表示
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request) {
        $keyword = $request->keyword;
        $expertContactTitles = new ExpertContactTitle();
        $expertContactTitles = $expertContactTitles->searchExpertContactTitles($keyword);

        $canCreate = Auth::guard('admin')->user()->can('create', ExpertContactTitle::class);
        $canDelete = Auth::guard('admin')->user()->can('delete', ExpertContactTitle::class);

        return Inertia::render('Admins/ExpertContactTitle/Index', [
            'expertContactTitles' => $expertContactTitles,
            'canCreate' => $canCreate,
            'canDelete' => $canDelete,
        ]);
    }


    /**
     * 専門人材問い合わせ項目登録
     * @param ExpertContactTitleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpertContactTitleRequest $request) {
        if(Auth::guard('admin')->user()->cannot('create', ExpertContactTitle::class)) {
            session()->flash('message', MessageConst::E_01001);
            return Inertia::location(route('admin.expert_contact_title.index'));
        }

        $params = $request->validated();
        try {
            ExpertContactTitle::create($params);
            session()->flash('message', MessageConst::EXPERT_CONTACT_TITLE . MessageConst::I_00001);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::EXPERT_CONTACT_TITLE . MessageConst::E_00001);
        }

        return Inertia::location(route('admin.expert_contact_title.index', ['page' => 1]));
    }


    /**
     * 専門人材問い合わせ項目編集画面表示
     * @param ExpertContactTitle $expertContactTitle
     * @return \Inertia\Response
     */
    public function edit(ExpertContactTitle $expertContactTitle) {
        return Inertia::render('Admins/ExpertContactTitle/Edit', [
            'expertContactTitle' => $expertContactTitle
        ]);
    }

    /**
     * 専門人材問い合わせ項目更新
     * @param ExpertContactTitleRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpertContactTitleRequest $request, $id) {
        if(Auth::guard('admin')->user()->cannot('update', ExpertContactTitle::class)) {
            session()->flash('message', MessageConst::E_01002);
            return Inertia::location(route('admin.expert_contact_title.index'));
        }

        $params = $request->validated();
        try {
            ExpertContactTitle::findOrFail($id)->update($params);
            session()->flash('message', MessageConst::EXPERT_CONTACT_TITLE . MessageConst::I_00002);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::EXPERT_CONTACT_TITLE . MessageConst::E_00002);
        }

        return Inertia::location(route('admin.expert_contact_title.index'));
    }

    /**
     * 専門人材問い合わせ項目複数削除
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        if(Auth::guard('admin')->user()->cannot('delete', ExpertContactTitle::class)) {
            session()->flash('message', MessageConst::E_01003);
            return Inertia::location(route('admin.expert_contact_title.index'));
        }

        $ids = $request->input('checked');
        $page = $request->input('page');
        $keyword = $request->input('keyword');

        $loginAdminId = Auth::guard('admin')->id();

        try {
            DB::transaction(function () use ($ids, $loginAdminId) {
                ExpertContactTitle::whereIn('id', $ids)->update(['deleted_by' => MessageConst::ADMIN_BY . $loginAdminId]);
                ExpertContactTitle::destroy($ids);
            }, 5);
            session()->flash('message', MessageConst::EXPERT_CONTACT_TITLE . MessageConst::I_00003);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::EXPERT_CONTACT_TITLE . MessageConst::E_00003);
        }

        return Inertia::location(route('admin.expert_contact_title.index', ['page' => $page, 'keyword' => $keyword]));

    }
}
