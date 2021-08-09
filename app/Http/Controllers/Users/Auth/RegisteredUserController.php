<?php

namespace App\Http\Controllers\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Users\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Users/Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {

        $user = User::create([
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

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
