<?php

namespace App\Http\Controllers\Users;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Users\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{


    public function update(Request $request)
    {

        $params = $request->validate([
            'chatroom_id' => 'required|exists:chatrooms,id',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'expert_id' => 'nullable|exists:experts,id'
        ]);

        $message = Message::firstOrCreate($params);
        event(new MessageEvent($message));

        return $message;
    }

    public function destroy(Message $message)
    {
        //
    }
}
