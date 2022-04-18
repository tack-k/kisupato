<?php

namespace App\Http\Controllers\Admins;

use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Models\Admins\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * 部署一覧画面表示
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request) {
        $keyword = $request->keyword;
        $departments = new Department();
        $departments = $departments->searchDepartments($keyword);

        $canCreate = Auth::guard('admin')->user()->can('create', Department::class);
        $canDelete = Auth::guard('admin')->user()->can('delete', Department::class);

        return Inertia::render('Admins/Department/Index', [
            'departments' => $departments,
            'canCreate' => $canCreate,
            'canDelete' => $canDelete,

        ]);
    }

    /**
     * 部署登録
     * @param DepartmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request) {
        if(Auth::guard('admin')->user()->cannot('create', Department::class)) {
            session()->flash('message', MessageConst::E_01001);
            return Inertia::location(route('admin.department.index'));
        }

        $params = $request->validated();
        try {
            Department::create($params);
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::I_00001);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::E_00001);
        }

        return Inertia::location(route('admin.department.index', ['page' => 1]));
    }

    /**
     * 部署編集画面表示
     * @param Department $department
     * @return \Inertia\Response
     */
    public function edit(Department $department) {
        return Inertia::render('Admins/Department/Edit', [
            'department' => $department
        ]);
    }

    /**
     * 部署更新
     * @param DepartmentRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id) {
        if(Auth::guard('admin')->user()->cannot('update', Department::class)) {
            session()->flash('message', MessageConst::E_01002);
            return Inertia::location(route('admin.department.index'));
        }

        $params = $request->validated();
        try {
            Department::findOrFail($id)->update($params);
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::I_00002);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::E_00002);
        }

        return Inertia::location(route('admin.department.index'));
    }

    /**
     * 部署複数削除
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        if(Auth::guard('admin')->user()->cannot('delete', Department::class)) {
            session()->flash('message', MessageConst::E_01003);
            return Inertia::location(route('admin.department.index'));
        }

        $ids = $request->input('checked');
        $page = $request->input('page');
        $keyword = $request->input('keyword');

        $loginAdminId = Auth::guard('admin')->id();

        try {
            Department::whereIn('id', $ids)->update(['deleted_by' => MessageConst::ADMIN_BY . $loginAdminId]);
            Department::destroy($ids);
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::I_DELETED);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::E_00003);
        }

        return Inertia::location(route('admin.department.index', ['page' => $page, 'keyword' => $keyword]));

    }
}
