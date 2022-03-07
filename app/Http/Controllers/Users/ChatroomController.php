<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\Chatroom;
use App\Models\Users\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;


class ChatroomController extends Controller {
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
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

        return redirect(route('chatroom.show', [
            'chatroomId' => $chatroom['id']
        ]));


    }

    public function show(Request $request, $chatroom_id)
    {

        $this->authorize('show-chatroom', [$chatroom_id]);

        $messages = Message::select(['message', 'messages.created_at', 'user_id', 'messages.expert_id', 'ep.profile_image'])
            ->leftjoin('expert_profiles as ep', 'ep.id', '=', 'messages.expert_id')
            ->where('chatroom_id', $chatroom_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return Inertia::render('Users/Chatrooms/Show', [
            'chatroomId' => $chatroom_id,
            'messages' => $messages,
        ]);
    }
}
