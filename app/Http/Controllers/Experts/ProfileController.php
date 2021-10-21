<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show() {
        return Inertia::render('Experts/Profile/Show');
    }

    public function input() {
        return Inertia::render(('Experts/Profile/Input'));
    }

    public function confirm(ProfileRequest $request) {
       $params = $request->validated();

        $params['skill_title'] = [];
        $params['skill_content'] = [];
       foreach ($params['skills'] as $skill) {
         array_push($params['skill_title'], $skill->skill_title);
         array_push($params['skill_content'], $skill->skill_content);
       }
var_dump($params);

        return Inertia::render(('Experts/Profile/Confirm'));

    }
}
