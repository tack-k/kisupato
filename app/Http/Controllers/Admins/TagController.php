<?php

namespace App\Http\Controllers\Admins;

use App\Consts\MessageConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Admins\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TagController extends Controller
{
    /**
     * 専門人材タグ一覧画面表示
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request) {
        $keyword = $request->keyword;
        $tags = new Tag();
        $tags = $tags->searchTags($keyword);

        $canCreate = Auth::guard('admin')->user()->can('create', Tag::class);
        $canDelete = Auth::guard('admin')->user()->can('delete', Tag::class);

        return Inertia::render('Admins/Tag/Index', [
            'tags' => $tags,
            'canCreate' => $canCreate,
            'canDelete' => $canDelete,
        ]);
    }


    /**
     * 専門人材タグ登録
     * @param TagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request) {
        if(Auth::guard('admin')->user()->cannot('create', Tag::class)) {
            session()->flash('message', MessageConst::E_01001);
            return Inertia::location(route('admin.tag.index'));
        }

        $params = $request->validated();
        try {
            Tag::create($params);
            session()->flash('message', MessageConst::TAG . MessageConst::I_00001);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::TAG . MessageConst::E_00001);
        }

        return Inertia::location(route('admin.tag.index', ['page' => 1]));
    }


    /**
     * 専門人材タグ編集画面表示
     * @param Tag $tag
     * @return \Inertia\Response
     */
    public function edit(Tag $tag) {
        return Inertia::render('Admins/Tag/Edit', [
            'tag' => $tag
        ]);
    }

    /**
     * 専門人材タグ更新
     * @param TagRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id) {
        if(Auth::guard('admin')->user()->cannot('update', Tag::class)) {
            session()->flash('message', MessageConst::E_01002);
            return Inertia::location(route('admin.tag.index'));
        }

        $params = $request->validated();
        try {
            Tag::findOrFail($id)->update($params);
            session()->flash('message', MessageConst::TAG . MessageConst::I_00002);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::TAG . MessageConst::E_00002);
        }

        return Inertia::location(route('admin.tag.index'));
    }

    /**
     * 専門人材タグ複数削除
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        if(Auth::guard('admin')->user()->cannot('delete', Tag::class)) {
            session()->flash('message', MessageConst::E_01003);
            return Inertia::location(route('admin.tag.index'));
        }

        $ids = $request->input('checked');
        $page = $request->input('page');
        $keyword = $request->input('keyword');

        $loginAdminId = Auth::guard('admin')->id();

        try {
            DB::transaction(function () use ($ids, $loginAdminId) {
                Tag::whereIn('id', $ids)->update(['deleted_by' => MessageConst::ADMIN_BY . $loginAdminId]);
                Tag::destroy($ids);
            }, 5);
            session()->flash('message', MessageConst::TAG . MessageConst::I_00003);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', MessageConst::TAG . MessageConst::E_00003);
        }

        return Inertia::location(route('admin.tag.index', ['page' => $page, 'keyword' => $keyword]));

    }
}
