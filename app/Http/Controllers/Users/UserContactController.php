<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContactRequest;
use App\Models\Admins\UserContactTitle;
use App\Models\Users\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UserContactController extends Controller {
    public function index() {
        //
    }

    public function create() {
        $params = session('contactInput');

        if(is_null($params)) {
            $user = Auth::user();
            $params['name'] = null;
            if(isset($user)) {
                $params['name'] = $user['last_name'] . $user['first_name'];
                $params['tel'] = $user['tel'];
                $params['email'] = $user['email'];
            }
        }


        $userContactTitle = UserContactTitle::select(['id', 'name'])->get();

        session()->forget('contactInput');

        return Inertia::render('Users/UserContacts/Create', [
            'params' => $params,
            'userContactTitle' => $userContactTitle,
        ]);
    }

    public function confirm(UserContactRequest $request) {
        $params = $request->validated();

        session(['contactInput' => $params]);
        $contactTitle = UserContactTitle::select(['name'])->where('id', $params['user_contact_title_id'])->first();
        $params['user_contact_title_name'] = $contactTitle['name'];
        return Inertia::render('Users/UserContacts/Confirm', [
            'params' => $params,
        ]);
    }

    public function finish(UserContactRequest $request) {
        $params = session()->get('contactInput');
        if (is_null($params)) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        $userId = Auth::id();
        if (isset($userId)) {
            $params['user_id'] = $userId;
        }

        UserContact::create($params);
        session()->forget('contactInput');

        return Inertia::render('Users/UserContacts/Finish');

    }

    public function store(Request $request) {
        //
    }

    public function show(UserContact $userContact) {
        //
    }

    public function edit(UserContact $userContact) {
        //
    }

    public function update(Request $request, UserContact $userContact) {
        //
    }

    public function destroy(UserContact $userContact) {
        //
    }
}
