<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id)
    // web.php ルーティングからurlのidの部分(引数)を渡す
    {
        // すべてのフォルダを取得する
        $folders = Folder::all();

        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get();
        // 下記を上記に書き換え、モデルFolderのhasmanyメソッドの関係性を定義済
        // $tasks = Task::where('folder_id', $current_folder->id)->get();
        // Tasks::where('folder_id', '=', $current_folder->id)->get();
        // 第一引数カラム名、第二引数比較する値
        // where からは QueryBuilder クラスのインスタンスが返っくる。QueryBuilder の get メソッドを呼ぶことで結果の詰まった Collection クラスのインスタンスが返ってくる
        // \App\Task::where('folder_id', 1)->toSql();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }
    /**
     * GET /folders/{id}/tasks/create
     */
    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    // 引数二つ int $id変数と、CreateTaskクラスのオブジェクト
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        // インスタンス化しないと使えない
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);
        // dd($current_folder);
        // exit;
        // save モデルをDBに書き込む
        // current_folderに紐づくtasksを登録する
        // メッソッドチェーン tasks()は、Folderクラスで、save()は、Folderクラスの親のModelクラスがもっている。

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }
}
