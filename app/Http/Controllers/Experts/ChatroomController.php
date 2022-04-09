<?php

namespace App\Http\Controllers\Experts;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Models\Experts\Chatroom;
use App\Models\Experts\Message;
use App\Models\Users\UserProfile;
use App\Services\ChatroomService;
use Carbon\Carbon;
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

        $messages = [];

        if ($chatrooms->isNotEmpty()) {
            $chatrooms = $this->_service->formatChatroomData($chatrooms);
        } else {
            $messages[] = 'チャットルームの登録がありません';
        }

        return Inertia::render('Experts/Chatrooms/Index', [
            'chatrooms' => $chatrooms,
            'messages' => $messages,
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

    public function update(Request $request) {
        $params = $request->validate([
            'id' => 'exists:chatrooms,id',
            'request_status' => 'between:0,4',
            'consultation_status' => 'between:0,2',
        ]);

        if($params['request_status'] === CommonConst::REQUEST_FINISHED) {
            $params['request_finished_at'] = Carbon::now();
        }
        Chatroom::find($params['id'])->update($params);

        return redirect()->route('expert.chatroom.index');
    }

}
