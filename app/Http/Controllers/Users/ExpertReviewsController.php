<?php

namespace App\Http\Controllers\Users;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertReviewRequest;
use App\Models\Users\Chatroom;
use App\Models\Users\ExpertReview;
use App\Services\CommonService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpertReviewsController extends Controller {

    protected $_commonService;

    public function __construct() {
        $this->_commonService = new CommonService();
    }

    public function index() {

        $userId = Auth::id();
        $reviews = ExpertReview::getCardReviews($userId)->get();

        $messages = [];

        if($reviews->isEmpty()) {
            $messages[] = 'レビューがありません';
        } else {
            foreach ($reviews as $review) {
                $review['created_date'] = $this->_commonService->formatDate($review['created_at']);
                $review['comment'] = $this->_commonService->limitNumberOfCharacters($review['comment'], CommonConst::MAX_REVIEW_COUNT);
            }
        }

        $reviewYet = Chatroom::getChatroomsRewviewYet($userId)->get();
        if(isset($reviewYet)) {

            $reviewYeyCount = count($reviewYet);
            $messages[] = "未レビューが{$reviewYeyCount}件あります";
        }

        return Inertia::render('Users/Review/Index', [
            'reviews' => $reviews,
            'messages' => $messages,
        ]);
    }

    public function yet() {

        $userId = \Auth::id();

        $chatrooms = Chatroom::getChatroomsRewviewYet($userId)->get();

        $commonService = new CommonService();

        foreach ($chatrooms as $chatroom) {
            $chatroom['request_finished_at'] = $commonService->formatDate($chatroom['request_finished_at']);
            $chatroom['request_enable_day'] = $commonService->afterDate($chatroom['request_finished_at'], CommonConst::REVIEW_TERM);

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
