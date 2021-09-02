<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Note;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 全てのメソッドが呼ばれる前に先に呼ばれるメソッド
        // 共通する処理をViewComposerに記述しておく
        view()->composer('*', function($view) {
            $query_tag = \Request::query('tag');
            // もしクエリパラメータtagがあれば
            if (!empty($query_tag)) {
                // タグ絞り込み
                $notes = Note::select('notes.*')
                    ->leftJoin('note_tags', 'note_tags.note_id', '=', 'notes.id')
                    ->where('note_tags.tag_id', '=', $query_tag)
                    ->where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
            } else {
                // タグが無ければ全て取得
                $notes = Note::select('notes.*')
                    ->where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
            }

            $tags = Tag::where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();

            // withの第一引数はViewで使う時の名前、第二引数は渡したい変数or配列名
            $view->with('notes', $notes)->with('tags', $tags);
        });
    }
}
