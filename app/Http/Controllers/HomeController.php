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

        return view('create', compact('notes'));
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
            $note_id = Note::insertGetId(['content' => $posts['content'], 'user_id' => \Auth::id()]);
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])->exists();
            if (!empty($posts['new_tag']) && !$tag_exists) {
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $posts['new_tag']]);
                NoteTag::insert(['note_id' => $note_id, 'tag_id' => $tag_id]);
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
