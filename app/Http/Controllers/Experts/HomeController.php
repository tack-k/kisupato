<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function top() {
        return Inertia::render('Experts/Home/Top');
    }
}
