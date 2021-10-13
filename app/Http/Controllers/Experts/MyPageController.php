<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyPageController extends Controller
{
    public function top() {
        return Inertia::render('Experts/MyPage/Top');
    }
}
