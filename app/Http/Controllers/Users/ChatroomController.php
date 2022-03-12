<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Experts\ExpertProfile;
use App\Models\Users\Chatroom;
use App\Models\Users\Message;
use App\Services\ChatroomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;


class ChatroomController extends Controller {

    protected $_service;

    public function __construct()
    {
        $this->_service = new ChatroomService();
    }

    public function index()
    {
        $userId = Auth::id();
        $chatrooms = Chatroom::getChatrooms($userId)->get();

        if ($chatrooms->isNotEmpty()) {
            $chatrooms = $this->_service->formatChatroomData($chatrooms);
        }

        return Inertia::render('Users/Chatrooms/Index', [
            'chatrooms' => $chatrooms,
        ]);
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
            $chatroom['id']
        ]));


    }

    public function show(Request $request, $chatroom_id)
    {

        $this->authorize('show-chatroom', [$chatroom_id]);

        $messages = Message::getMessages($chatroom_id)->get();
        $chatroom = Chatroom::find($chatroom_id);
        $expertProfile = ExpertProfile::getExpertProfileForChatroom($chatroom['expert_id'])->first();

        return Inertia::render('Users/Chatrooms/Show', [
            'chatroomId' => $chatroom_id,
            'messages' => $messages,
            'expertProfile' => $expertProfile,
        ]);
    }
}
