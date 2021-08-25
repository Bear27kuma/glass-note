<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            // idがマイナスになることはないので、符号なし
            $table->unsignedBigInteger('id', true);
            $table->longText('content');
            $table->unsignedBigInteger('user_id');
            // 論理削除を定義 -> deleted_atを自動生成
            $table->softDeletes();
            // timestamps()だけで自動でcreated_atとupdated_atを作るが、デフォルト値がないため、直接DBに記述する
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            // 外部キー制約をつける
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
