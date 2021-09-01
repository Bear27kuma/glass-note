<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Note;
use App\Models\Tag;
use App\Models\NoteTag;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notes = Note::select('notes.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();


        return view('create', compact('notes', 'tags'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */

    public function store(Request $request) {
        $posts = $request->all();

        // ===== トランザクション開始 =====
        DB::transaction(function () use($posts) {
            // ノートIDをインサートして取得
            $note_id = Note::insertGetId(['content' => $posts['content'], 'user_id' => \Auth::id()]);
            // タグが存在するかどうかを真偽値で返す
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])->exists();
            // 新規タグが入っているかのチェック（ない場合に新しくインサートする）
            if (!empty($posts['new_tag']) && !$tag_exists) {
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $posts['new_tag']]);
                NoteTag::insert(['note_id' => $note_id, 'tag_id' => $tag_id]);
            }
            // 既存タグが紐付けられた場合 -> note_tagsにインサート
            foreach($posts['tags'] as $tag) {
                NoteTag::insert(['note_id' => $note_id, 'tag_id' => $tag]);
            }
        });
        // ===== トランザクション終了 =====

        return redirect( route('home') );
    }


    /**
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        $notes = Note::select('notes.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $edit_note = Note::find($id);

        return view('edit', compact('notes', 'edit_note'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request) {
        $posts = $request->all();

        Note::where('id', '=', $posts['note_id'])->update(['content' => $posts['content']]);

        return redirect( route('home') );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Request $request) {
        $posts = $request->all();

        Note::where('id', '=', $posts['note_id'])->update(['deleted_at' => date('Y-m-d H:i:s', time())]);

        return redirect( route('home') );
    }
}
