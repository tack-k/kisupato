<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\ExpertReview;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpertReviewsController extends Controller {

    public function yet() {
        return Inertia::render('Users/Review/Yet');
    }

}
