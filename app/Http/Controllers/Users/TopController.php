<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Testing\Assert;

class TopController extends Controller
{
    public function index() {

       return Inertia::render('Users/Top/Index');
    }
}
