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
            // ノート取得はモデルに任せる
            // 外部からuseしたモデルはインスタンス化する必要がある -> 他のファイルでモデルに記述した関数などが使える
            $note_model = new Note();
            $notes = $note_model->getMyNotes();


            $tags = Tag::where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();

            // withの第一引数はViewで使う時の名前、第二引数は渡したい変数or配列名
            $view->with('notes', $notes)->with('tags', $tags);
        });
    }
}
