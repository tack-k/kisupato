<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertAccountRequest;
use App\Http\Requests\ExpertRequest;
use App\Models\Experts\Expert;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ExpertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Experts/Auth/Register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\ExpertRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpertRequest $request)
    {
        $expert = Expert::create([
            'last_name' => $request->last_name,
            'first_name' => $request->last_name_kana,
            'last_name_kana' => $request->last_name_kana,
            'first_name_kana' => $request->first_name_kana,
            'email' => $request->email,
            'tel' => $request->tel,
            'postal_code' => $request->postal_code,
            'region' => $request->region,
            'city' => $request->city,
            'street' => $request->street,
            'building' => $request->building,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($expert));

        Auth::guard('expert')->login($expert);

        return redirect(route('expert.myPage.top'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Inertia::render('Experts/Account/Show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return Inertia::render('Experts/Account/Edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ExpertAccountRequest $request)
    {
        $params = $request->except([
            'current_password',
            'password_confirmation',
            'password',
            'is_password_change',
        ]);

        if(isset($request->password)) {
            $params['password'] = Hash::make($request->password);
        }

        $expertId = Auth::guard('expert')->id();
        Expert::where('id', $expertId)->update($params);

        session()->flash('message', 'アカウント情報を変更しました。');

        return redirect()->route('expert.account.show');
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
}
