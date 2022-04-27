<?php

namespace App\Http\Controllers\Admins;

use App\Consts\CommonConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailMagazineRequest;
use App\Models\Admins\MailMagazine;
use App\Models\Admins\Position;
use App\Models\Admins\Tag;
use App\Models\Experts\Expert;
use App\Models\Users\User;
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
        $params = $request->except(['checked_tags', 'checked_positions']);
        $target = $request->input('target');

        if ($target === CommonConst::TARGET_ALL) {
            $expertEmails = Expert::select('email')->get();
            $sentExpertMailCount = count($expertEmails);
        }
        if($target === CommonConst::TARGET_SELECT) {
            $checkedTags = $request->input('checked_tags');
            $checkedPositions = $request->input('checked_positions');

            $expertEmails = Expert::select('email')
                ->join('expert_profiles as ep', 'ep.expert_id', '=', 'experts.id')
                ->join('expert_profiles_tags as ept', 'ept.expert_profile_id', '=', 'ep.id')
                ->join('expert_profiles_positions as epp', 'epp.expert_profile_id', '=', 'ep.id')
                ->whereIn('ept.tag_id', $checkedTags)
                ->orWhereIn('epp.position_id', $checkedPositions)
                ->distinct()
                ->get();
            $sentExpertMailCount = count($expertEmails);
        }
    }

    public function destroy(MailMagazine $mailMagazine) {
        //
    }
}
