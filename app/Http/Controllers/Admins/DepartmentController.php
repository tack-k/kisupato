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
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::I_00003);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::DEPARTMENT . MessageConst::E_00003);
        }

        return Inertia::location(route('admin.department.index', ['page' => $page, 'keyword' => $keyword]));

    }
}
