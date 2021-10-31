<?php

namespace App\Http\Controllers\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Services\ProfileService;

class ProfileController extends Controller {
    protected $_service;

    public function __construct(ProfileService $_service) {
        $this->_service = $_service;
    }

    public function show() {
        return Inertia::render('Experts/Profile/Show');
    }

    public function input() {
        return Inertia::render(('Experts/Profile/Input'));
    }

    public function preUpdate(ProfileRequest $request) {
        $params = $request->except(['image', 'activity_image']);

        //画像パスを作成しパラメーターをセッションに保存
        $this->_service->saveParams($request, $params);

        return Redirect()->route(('expert.profile.confirm'));

    }

    public function confirm() {
        $params = session()->pull('input_profile');

        if (empty($params)) {
            return Redirect::route('expert.profile.show');
        }

        return Inertia::render('Experts/Profile/Confirm', [
            'params' => $params,
        ]);
    }
}

