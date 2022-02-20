<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\UserContact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserContactController extends Controller {
    public function index() {
        //
    }

    public function create() {

        return Inertia::render('Users/UserContacts/Create');
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
