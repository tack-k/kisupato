<?php

namespace App\Http\Controllers\Experts;

use App\Consts\CommonConst;
use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserReviewRequest;
use App\Models\Experts\Chatroom;
use App\Models\Experts\UserReview;
use App\Services\CommonService;
use Inertia\Inertia;

class UserReviewsController extends Controller {

    protected $_commonService;

    public function __construct() {
        $this->_commonService = new CommonService();
    }

    public function index() {

        $expertId = $this->_commonService->getExpertId();
        $reviews = UserReview::getSelfReviews($expertId)->get();

        $messages = [];

        if ($reviews->isEmpty()) {
            $messages[] = 'レビューがありません';
        } else {
            foreach ($reviews as $review) {
                $review['created_date'] = $this->_commonService->formatDate($review['created_at']);
            }
        }

        $reviewYet = Chatroom::getChatroomsReviewYet($expertId)->get();
        if (isset($reviewYet)) {

            $reviewYeyCount = count($reviewYet);
            if ($reviewYeyCount !== 0) {
                $messages[] = "未レビューが{$reviewYeyCount}件あります";
            }
        }

        return Inertia::render('Experts/Review/Index', [
            'reviews' => $reviews,
            'messages' => $messages,
        ]);
    }

    public function yet() {

        $expertId = $this->_commonService->getExpertId();

        $chatrooms = Chatroom::getChatroomsReviewYet($expertId)->get();

        foreach ($chatrooms as $chatroom) {
            $chatroom['request_finished_at'] = $this->_commonService->formatDate($chatroom['request_finished_at']);
            $chatroom['request_enable_day'] = $this->_commonService->afterDate($chatroom['request_finished_at'], CommonConst::REVIEW_TERM);

        }

        return Inertia::render('Experts/Review/Yet', [
            'chatrooms' => $chatrooms,
        ]);
    }

    public function store(UserReviewRequest $request) {

        $expertId = $this->_commonService->getExpertId();
        $reviewParams = $request->validated();
        $reviewParams['expert_id'] = $expertId;

        UserReview::create($reviewParams);

        session()->flash('message', MessageConst::REVIEW . MessageConst::I_REGISTER);

        return redirect()->route('expert.review.yet');
    }
}
