<?php

namespace App\Http\Controllers\Users;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Models\Users\Chatroom;
use App\Models\Users\ExpertReview;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpertReviewsController extends Controller {

    public function yet() {

        $userId = \Auth::id();

        $chatrooms = Chatroom::select('chatrooms.id', 'ep.nickname', 'ep.profile_image', 'request_finished_at')
            ->join('expert_profiles as ep', 'ep.expert_id', '=', 'chatrooms.expert_id')
            ->where('chatrooms.user_id', $userId)
            ->where('chatrooms.request_status', CommonConst::REQUEST_FINISHED)
            ->get();

        $commonService = new CommonService();

        foreach ($chatrooms as $chatroom) {
            $chatroom['request_finished_at'] = $commonService->formatDate($chatroom['request_finished_at']);
        }

        return Inertia::render('Users/Review/Yet', [
            'chatrooms' => $chatrooms,
        ]);
    }

    public function store() {

    }

}
