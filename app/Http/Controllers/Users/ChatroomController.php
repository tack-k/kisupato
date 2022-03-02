<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\Chatroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatroomController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request) {
        $params = $request->validate([
            'expert_id' => 'exists:experts,id'
        ]);

        $userId = Auth::id();
        $params = [
            'user_id' => $userId,
            'expert_id' => $params['expert_id'],
        ];

        $chatroom = Chatroom::getChatroom($userId, $params['expert_id'])->first();

        if (is_null($chatroom)) {
            $chatroom = Chatroom::create($params);
        }

        return redirect(route('chatroom.show', [$chatroom['id']]));


    }

    public function show(Request $request, $expert_id) {
        return Inertia::render('Users/Chatrooms/Show');
    }
}
