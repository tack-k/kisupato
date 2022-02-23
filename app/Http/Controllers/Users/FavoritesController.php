<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller {
    public function index() {
        //
    }

    public function switch(Request $request) {

        $validator = \Validator::make($request->all(), [
            'expert_id' => 'required|exists:experts,id'
        ]);

        if ($validator->fails()) {
            \Log::error('validation error');
            return;
        }

        $params = $validator->validated();

        $params['user_id'] = \Auth::id();

        $favorite = Favorite::getFavorite($params['expert_id'], $params['user_id'])->first();
        if (isset($favorite)) {
            $favorite->delete();
        } else {
            Favorite::create($params);
        }

    }


}
