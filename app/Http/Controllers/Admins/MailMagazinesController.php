<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailMagazineRequest;
use App\Models\Admins\MailMagazine;
use App\Models\Admins\Position;
use App\Models\Admins\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MailMagazinesController extends Controller {
    public function index() {
        //
    }

    public function create() {

        $tags = Tag::getTags()->get();
        $positions = Position::getPositions()->get();

        return Inertia::render('Admins/MailMagazine/Create', [
            'tags' => $tags,
            'positions' => $positions,
        ]);
    }

    public function store(Request $request) {
        //
    }

    public function show(MailMagazine $mailMagazine) {
        //
    }

    public function edit(MailMagazine $mailMagazine) {
        //
    }

    public function update(MailMagazineRequest $request, MailMagazine $mailMagazine) {

    }

    public function destroy(MailMagazine $mailMagazine) {
        //
    }
}
