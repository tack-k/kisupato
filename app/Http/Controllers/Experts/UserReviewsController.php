<?php

namespace App\Http\Controllers\Experts;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Models\Experts\Chatroom;
use App\Services\CommonService;
use Inertia\Inertia;

class UserReviewsController extends Controller {

    protected $_commonService;

    public function __construct() {
        $this->_commonService = new CommonService();
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
}
