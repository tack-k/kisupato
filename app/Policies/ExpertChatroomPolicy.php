<?php

namespace App\Policies;

use App\Models\Experts\Chatroom;
use App\Models\Experts\Expert;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpertChatroomPolicy {
    use HandlesAuthorization;

    public function __construct() {
        //
    }

    public function view(Expert $expert, $id): bool {
        $chatroom = Chatroom::find($id);
        return $expert->id === $chatroom->expert_id;
    }
}
