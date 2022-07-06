<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
  // クエリビルダーの書き方
  // $tasks = Tasks::where('folder_id', $current_folder->id)->get();
  // ORM(エロクアント)の書き方で実行できるようにする。
  // $tasks = $current_folder->tasks()->get();
  public function tasks()
  {
      return $this->hasMany('App\Task');
      // モデルクラスにおけるリレーション
      // １対多の関係性を定義する。以下が省略されている。
      // $this->hasMany('App\Task', 'folder_id', 'id');
  }
}
