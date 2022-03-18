<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAccountRequest;
use App\Http\Requests\UserRequest;
use App\Models\Users\User;
use App\Models\Users\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller {
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
        return Inertia::render('Users/Auth/Register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $params = $request->except(['nickname']);
            $params['password'] = Hash::make($request->password);
            $user = User::create($params);

            $profile = $request->only(['nickname']);
            $profile['user_id'] = $user['id'];
            $profile['profile_image'] = 'default_profile.png';

            UserProfile::create($profile);

            event(new Registered($user));

            Auth::login($user);
        });

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Inertia::render('Users/Account/Show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit()
    {
        return Inertia::render('Users/Account/Edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserAccountRequest $request)
    {

        $params = $request->except([
            'current_password',
            'password_confirmation',
        ]);
        $params['password'] = Hash::make($request->password);

        User::update($params);

        return redirect()->route('account.show');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
