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
        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        // compactメソッドに変数名を指定すると、Viewに値を渡せる
        return view('create', compact('tags'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */

    public function store(Request $request) {
        $posts = $request->all();
        // バリデーション（ノートの内容が必須）、contentはビューのname属性
        $request->validate(['content' => 'required']);

        // dump dieの略 → メソッドの引数に取った値を展開して止める → データ確認
        // dd(\Auth::id());

        // ===== トランザクション開始 =====
        // クロージャを使う
        DB::transaction(function() use($posts) {
            // ノートIDをインサートして取得
            // insertGetIdではインサートしてそのidを返す
            $note_id = Note::insertGetId(['content' => $posts['content'], 'user_id' => \Auth::id()]);
            // 新規タグがすでにtagsテーブルに存在するのかチェック
            // where文は続けて書くことができ、その場合「かつ」の意味になる
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])->exists();
            // 新規タグが入っているかのチェック（また、既存タグの中に一致しない場合に新しくインサートする）
            if (!empty($posts['new_tag']) && !$tag_exists) {
                // 新規タグが存在すれば、tagsテーブルにインサート → IDを取得（中間テーブルにtag_idを入れるため）
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $posts['new_tag']]);
                // note_tagsにインサートして、ノートとタグを紐づける
                NoteTag::insert(['note_id' => $note_id, 'tag_id' => $tag_id]);
            }

            // 既存タグが紐付けられた場合 -> note_tagsにインサート
            if (!empty($posts['tags'])) {
                foreach($posts['tags'] as $tag) {
                    NoteTag::insert(['note_id' => $note_id, 'tag_id' => $tag]);
                }
            }
        });
        // ===== トランザクション終了 =====

        // /homeにリダイレクトする
        return redirect( route('home') );
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        // 条件に一致するデータを取得する
        $edit_note = Note::select('notes.*', 'tags.id AS tag_id')
            ->leftJoin('note_tags', 'note_tags.note_id', '=', 'notes.id')
            ->leftJoin('tags', 'note_tags.tag_id', '=', 'tags.id')
            ->where('notes.user_id', '=', \Auth::id())
            ->where('notes.id', '=', $id)
            ->whereNull('notes.deleted_at')
            ->get();

        // tagは複数存在する可能性があるので、配列に格納してからViewに渡す
        $include_tags = [];
        foreach($edit_note as $note) {
            $include_tags[] = $note['tag_id'];
        }

        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return view('edit', compact('edit_note', 'include_tags', 'tags'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request) {
        $posts = $request->all();
        $request->validate(['content' => 'required']);
        // ===== トランザクション開始 =====
        DB::transaction(function() use($posts) {
            // updateでは必ずwhereをつけて、どのnote_idがupdateされるかをDBに示してあげる
            Note::where('id', '=', $posts['note_id'])->update(['content' => $posts['content']]);
            // 一旦ノートとタグの紐付けを削除 → 中間テーブルを一旦削除
            NoteTag::where('note_id', '=', $posts['note_id'])->delete();
            // 再度ノートとタグの紐付け
            if (!empty($posts['tags'])) {
                foreach($posts['tags'] as $tag) {
                    NoteTag::insert(['note_id' => $posts['note_id'], 'tag_id' => $tag]);
                }
            }
            // 新規タグがすでにtagsテーブルに存在するのかチェック
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])->exists();
            // 新規タグが入っているかのチェック
            // もし、新しいタグの入力があれば、インサートして紐づける
            if (!empty($posts['new_tag']) && !$tag_exists) {
                // 新規タグが存在しなければ、tagsテーブルにインサート → IDを取得（中間テーブルにtag_idを入れるため）
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $posts['new_tag']]);
                // note_tagsにインサートして、ノートとタグを紐づける
                NoteTag::insert(['note_id' => $posts['note_id'], 'tag_id' => $tag_id]);
            }
        });
        // ===== トランザクション終了 =====

        return redirect( route('home') );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Request $request) {
        $posts = $request->all();

        // deleteで削除してしまうと物理削除=データごと全て消してしまい、DBに何も残らなくなるため復元ができなくなる
        // deleted_atカラムにタイムスタンプを入れることで、DBにデータは残っているけどページには表示されない=論理削除になる
        Note::where('id', '=', $posts['note_id'])->update(['deleted_at' => date('Y-m-d H:i:s', time())]);

        return redirect( route('home') );
    }
}
