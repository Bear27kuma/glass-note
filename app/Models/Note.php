<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public function getMyNotes() {
        $query_tag = \Request::query('tag');
        // ===== メソッドのベース開始 =====
        // タグ絞り込み
        $query = Note::query()
            ->select('notes.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC');
        // ===== メソッドのベース終了 =====

        // もしクエリパラメータtagがあれば
        if (!empty($query_tag)) {
            $query
                ->leftJoin('note_tags', 'note_tags.note_id', '=', 'notes.id')
                ->where('note_tags.tag_id', '=', $query_tag);
        }

        $notes = $query->get();

        return $notes;
    }
}
