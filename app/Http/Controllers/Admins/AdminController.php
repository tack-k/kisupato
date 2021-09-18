<?php

namespace App\Http\Controllers\Admins;

use App\Consts\AdminConst;
use App\Http\Controllers\Controller;
use App\Models\Admins\Admin;
use App\Http\Requests\AdminRequest;
use App\Models\Admins\Authority;
use App\Models\Admins\Department;
use App\Mail\CreateAdmin;
use App\Http\Requests\InitializePasswordRequest;
use App\Rules\AdminStatusRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InvalidOrderException;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $authorities = Authority::all();
        $departments = Department::all();

        $keyword = $request->keyword;
        $admins = new Admin();
        $admins = $admins->searchAdmins($keyword);

        $canCreate = Auth::guard('admin')->user()->can('create', Admin::class);
        $canDelete = Auth::guard('admin')->user()->can('delete', Admin::class);

        return Inertia::render('Admins/Admin/Index',
            [
                'authorities' => $authorities,
                'departments' => $departments,
                'admins' => $admins,
                'keyword' => $keyword,
                'canCreate' => $canCreate,
                'canDelete' => $canDelete,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminRequest $request
     * @return
     */
    public function store(AdminRequest $request)
    {

        if(Auth::guard('admin')->user()->cannot('create', Admin::class)) {
            session()->flash('message', '作成権限がありません。');
            return Inertia::location(route('admin.index'));
        }
        $params = $request->validated();
        $password = Str::random(10);
        $params['password'] = Hash::make($password);

        $admin = Admin::create($params);

        Mail::to($admin->email)->send(new CreateAdmin($admin->email, $password));

        $request->session()->flash('message', 'ご登録いただいたメールアドレスにアカウント発行のメールを送信しました。');
        return Inertia::location(route('admin.index', ['page' => 1]));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function  delete(Request $request) {


        $ids = $request->checked;
        $params = $request->validate([
           'checked' => [new AdminStatusRule($ids)]
        ]);
        try {
            $page = $request->page;
            $keyword = $request->keyword;
            Admin::destroy($ids);
            session()->flash('message', '削除しました');
        } catch (Throwable $e) {
            report($e);
            session()->flash('message', '削除できませんでした');
        }

        return Inertia::location(route('admin.index', ['page' => $page, 'keyword' => $keyword]));

    }

    public function inputInitPassword() {
        return Inertia::render('Admins/Auth/InputInitPassword');
    }

    public function initializePassword(InitializePasswordRequest $request) {
        $params = $request->validated();
        $newPassword = Hash::make($params['password']);

        $admin = Auth::guard('admin')->user();
        $admin->password = $newPassword;
        $admin->password_init_flag = AdminConst::INITIALIZED;
        $admin->save();
        session()->flash('message', '初期パスワードを変更しました。');
        return Inertia::location(route('admin.index'));

    }

}
