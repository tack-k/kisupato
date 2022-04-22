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

        //指定期間経過後、レビューがある場合は公開する
        $expertReviews = ExpertReview::getExpertReviewsPassedTerm()->get();

        if($expertReviews->isNotEmpty()) {
            $expertReviewParams = [];
            foreach ($expertReviews as $expertReview) {
                $expertReviewParams[] = [
                    'id' => $expertReview['id'],
                    'chatroom_id' => $expertReview['chatroom_id'],
                    'expert_id' => $expertReview['expert_id'],
                    'user_id' => $expertReview['user_id'],
                    'status' => CommonConst::REVIEW_PUBLIC,
                    'evaluation' => $expertReview['evaluation'],
                ];
            }

            ExpertReview::upsert($expertReviewParams, ['id', 'chatroom_id'], ['status']);
        }

        $userReviews = UserReview::getUserReviewsPassedTerm()->get();

        if($userReviews->isNotEmpty()) {
            $userReviewParams = [];
            foreach ($userReviews as $userReview) {
                $userReviewParams[] = [
                    'id' => $userReview['id'],
                    'chatroom_id' => $userReview['chatroom_id'],
                    'expert_id' => $userReview['expert_id'],
                    'user_id' => $userReview['user_id'],
                    'status' => CommonConst::REVIEW_PUBLIC,
                    'evaluation' => $userReview['evaluation'],
                ];
            }

             UserReview::upsert($userReviewParams, ['id', 'chatroom_id'], ['status']);
        }
    }
}
