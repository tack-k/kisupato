<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatroomController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Request $request, $expert_id) {
        return Inertia::render('Users/Chatrooms/Show');
    }
}
