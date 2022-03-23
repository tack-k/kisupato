<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertReviewRequest;
use App\Models\Users\Chatroom;
use App\Models\Users\ExpertReview;
use App\Services\CommonService;
use Inertia\Inertia;

class ExpertReviewsController extends Controller {

    public function yet() {

        $userId = \Auth::id();

        $chatrooms = Chatroom::getChatroomsRewviewYet($userId)->get();

        $commonService = new CommonService();

        foreach ($chatrooms as $chatroom) {
            $chatroom['request_finished_at'] = $commonService->formatDate($chatroom['request_finished_at']);
        }

        return Inertia::render('Users/Review/Yet', [
            'chatrooms' => $chatrooms,
        ]);
    }

    public function store(ExpertReviewRequest $request) {

        $userId = \Auth::id();
        $reviewParams = $request->validated();
        $reviewParams['user_id'] = $userId;

        ExpertReview::create($reviewParams);

        session()->flash('message', 'レビューを登録しました');

        return redirect()->route('review.yet');
    }

}
