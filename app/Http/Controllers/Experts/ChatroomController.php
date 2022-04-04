<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Models\Experts\Chatroom;
use App\Models\Experts\Message;
use App\Models\Users\UserProfile;
use App\Services\ChatroomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatroomController extends Controller {

    protected $_service;

    public function __construct() {
        $this->_service = new ChatroomService();
    }

    public function index() {

        $expertId = Auth::guard('expert')->id();

        $chatrooms = Chatroom::getChatrooms($expertId)->get();

        if ($chatrooms->isNotEmpty()) {
            $chatrooms = $this->_service->formatChatroomData($chatrooms);
        }

        return Inertia::render('Experts/Chatrooms/Index', [
            'chatrooms' => $chatrooms,
        ]);
    }

    public function show(Request $request, $chatroom_id) {

        $this->authorize('show-expertChatroom', [$chatroom_id]);

        $messages = Message::getMessages($chatroom_id)->get();
        $chatroom = Chatroom::find($chatroom_id);
        $this->_service->addChatroomStatusName($chatroom);

        $userProfile = UserProfile::getUserProfile($chatroom['user_id'])->first();

        return Inertia::render('Experts/Chatrooms/Show', [
            'chatroom' => $chatroom,
            'messages' => $messages,
            'userProfile' => $userProfile,
        ]);

    }
}
