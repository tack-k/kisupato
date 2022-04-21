<?php

namespace App\Console\Commands;

use App\Consts\CommonConst;
use App\Models\Experts\UserReview;
use App\Models\Users\ExpertReview;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PublishReviewCommand extends Command {
    protected $signature = 'publish:review';

    protected $description = 'publish user and expert reviews';

    public function handle() {
        //お互いがレビュー済みの場合は公開する
        $reviews = UserReview::getPrivateReviews()->get();
        $userReviews = [];
        $expertReviews = [];

        if ($reviews->isNotEmpty()) {
            foreach ($reviews as $review) {
                $userReviews[] = [
                    'id' => $review['user_reviews_id'],
                    'chatroom_id' => $review['chatroom_id'],
                    'user_id' => $review['user_id'],
                    'expert_id' => $review['expert_id'],
                    'evaluation' => $review['user_evaluation'],
                    'status' => CommonConst::REVIEW_PUBLIC,
                ];

                $expertReviews[] = [
                    'id' => $review['expert_reviews_id'],
                    'chatroom_id' => $review['chatroom_id'],
                    'user_id' => $review['user_id'],
                    'expert_id' => $review['expert_id'],
                    'evaluation' => $review['expert_evaluation'],
                    'status' => CommonConst::REVIEW_PRIVATE,
                ];
            }

            DB::transaction(function () use ($userReviews, $expertReviews) {
                UserReview::upsert($userReviews, ['id', 'chatroom_id'], ['status']);
                ExpertReview::upsert($expertReviews, ['id', 'chatroom_id'], ['status']);
            });
        }
    }
}
