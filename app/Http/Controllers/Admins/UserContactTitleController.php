<?php

namespace App\Http\Controllers\Admins;

use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserContactTitleRequest;
use App\Models\Admins\UserContactTitle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserContactTitleController extends Controller
{
    /**
     * ユーザー問い合わせ項目一覧画面表示
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request) {
        $keyword = $request->keyword;
        $userContactTitles = new UserContactTitle();
        $userContactTitles = $userContactTitles->searchUserContactTitles($keyword);

        $canCreate = Auth::guard('admin')->user()->can('create', UserContactTitle::class);
        $canDelete = Auth::guard('admin')->user()->can('delete', UserContactTitle::class);

        return Inertia::render('Admins/UserContactTitle/Index', [
            'userContactTitles' => $userContactTitles,
            'canCreate' => $canCreate,
            'canDelete' => $canDelete,
        ]);
    }


    /**
     * ユーザー問い合わせ項目登録
     * @param UserContactTitleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserContactTitleRequest $request) {
        if(Auth::guard('admin')->user()->cannot('create', UserContactTitle::class)) {
            session()->flash('message', MessageConst::E_01001);
            return Inertia::location(route('admin.user_contact_title.index'));
        }

        $params = $request->validated();
        try {
            UserContactTitle::create($params);
            session()->flash('message', MessageConst::USER_CONTACT_TITLE . MessageConst::I_00001);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::USER_CONTACT_TITLE . MessageConst::E_00001);
        }

        return Inertia::location(route('admin.user_contact_title.index', ['page' => 1]));
    }


    /**
     * ユーザー問い合わせ項目編集画面表示
     * @param UserContactTitle $userContactTitle
     * @return \Inertia\Response
     */
    public function edit(UserContactTitle $userContactTitle) {
        return Inertia::render('Admins/UserContactTitle/Edit', [
            'userContactTitle' => $userContactTitle
        ]);
    }

    /**
     * ユーザー問い合わせ項目更新
     * @param UserContactTitleRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserContactTitleRequest $request, $id) {
        if(Auth::guard('admin')->user()->cannot('update', UserContactTitle::class)) {
            session()->flash('message', MessageConst::E_01002);
            return Inertia::location(route('admin.user_contact_title.index'));
        }

        $params = $request->validated();
        try {
            UserContactTitle::findOrFail($id)->update($params);
            session()->flash('message', MessageConst::USER_CONTACT_TITLE . MessageConst::I_00002);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::USER_CONTACT_TITLE . MessageConst::E_00002);
        }

        return Inertia::location(route('admin.user_contact_title.index'));
    }

    /**
     * ユーザー問い合わせ項目複数削除
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        if(Auth::guard('admin')->user()->cannot('delete', UserContactTitle::class)) {
            session()->flash('message', MessageConst::E_01003);
            return Inertia::location(route('admin.user_contact_title.index'));
        }

        $ids = $request->input('checked');
        $page = $request->input('page');
        $keyword = $request->input('keyword');

        $loginAdminId = Auth::guard('admin')->id();

        try {
            DB::transaction(function () use ($ids, $loginAdminId) {
                UserContactTitle::whereIn('id', $ids)->update(['deleted_by' => MessageConst::ADMIN_BY . $loginAdminId]);
                UserContactTitle::destroy($ids);
            }, 5);
            session()->flash('message', MessageConst::USER_CONTACT_TITLE . MessageConst::I_DELETED);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::USER_CONTACT_TITLE . MessageConst::E_00003);
        }

        return Inertia::location(route('admin.user_contact_title.index', ['page' => $page, 'keyword' => $keyword]));

    }
}
