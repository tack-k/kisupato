<?php

namespace App\Policies;

use App\Models\Users\Chatroom;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatroomPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function view($user, $id): bool
    {
        $chatroom = Chatroom::find($id);
        return $user->id === $chatroom->user_id;
    }
}
