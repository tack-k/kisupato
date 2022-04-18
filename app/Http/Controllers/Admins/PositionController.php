<?php

namespace App\Http\Controllers\Admins;

use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Models\Admins\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PositionController extends Controller
{
    /**
     * 専門人材肩書一覧画面表示
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request) {
        $keyword = $request->keyword;
        $positions = new Position();
        $positions = $positions->searchPositions($keyword);

        $canCreate = Auth::guard('admin')->user()->can('create', Position::class);
        $canDelete = Auth::guard('admin')->user()->can('delete', Position::class);

        return Inertia::render('Admins/Position/Index', [
            'positions' => $positions,
            'canCreate' => $canCreate,
            'canDelete' => $canDelete,
        ]);
    }


    /**
     * 専門人材肩書登録
     * @param PositionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionRequest $request) {
        if(Auth::guard('admin')->user()->cannot('create', Position::class)) {
            session()->flash('message', MessageConst::E_01001);
            return Inertia::location(route('admin.position.index'));
        }

        $params = $request->validated();
        try {
            Position::create($params);
            session()->flash('message', MessageConst::POSITION . MessageConst::I_00001);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::POSITION . MessageConst::E_00001);
        }

        return Inertia::location(route('admin.position.index', ['page' => 1]));
    }


    /**
     * 専門人材肩書編集画面表示
     * @param Position $position
     * @return \Inertia\Response
     */
    public function edit(Position $position) {
        return Inertia::render('Admins/Position/Edit', [
            'position' => $position
        ]);
    }

    /**
     * 専門人材肩書更新
     * @param PositionRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, $id) {
        if(Auth::guard('admin')->user()->cannot('update', Position::class)) {
            session()->flash('message', MessageConst::E_01002);
            return Inertia::location(route('admin.position.index'));
        }

        $params = $request->validated();
        try {
            Position::findOrFail($id)->update($params);
            session()->flash('message', MessageConst::POSITION . MessageConst::I_00002);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::POSITION . MessageConst::E_00002);
        }

        return Inertia::location(route('admin.position.index'));
    }

    /**
     * 専門人材肩書複数削除
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        if(Auth::guard('admin')->user()->cannot('delete', Position::class)) {
            session()->flash('message', MessageConst::E_01003);
            return Inertia::location(route('admin.position.index'));
        }

        $ids = $request->input('checked');
        $page = $request->input('page');
        $keyword = $request->input('keyword');

        $loginAdminId = Auth::guard('admin')->id();

        try {
            DB::transaction(function () use ($ids, $loginAdminId) {
                Position::whereIn('id', $ids)->update(['deleted_by' => MessageConst::ADMIN_BY . $loginAdminId]);
                Position::destroy($ids);
            }, 5);
            session()->flash('message', MessageConst::POSITION . MessageConst::I_DELETED);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::POSITION . MessageConst::E_00003);
        }

        return Inertia::location(route('admin.position.index', ['page' => $page, 'keyword' => $keyword]));

    }
}
