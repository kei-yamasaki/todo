<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\EditTask;
use App\Http\Requests\CreateTask;
// ★ Authクラスをインポートする
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 引数(int $id)を変更 ルートとモデルを結びつける（バインディング）
    // Lravelで、モデルに紐づくURLかどうかをcheckして、なければ、abort 404を返す仕組み
    public function index(Folder $folder)
    // web.php ルーティングからurlのidの部分(引数)を渡す
    {
        // 権限がない場合のコンテンツへのアクセス対策
        if (Auth::user()->id !== $folder->user_id) {
            abort(403);
        }

        // ★ ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();
        // すべてのフォルダを取得する
        // $folders = Folder::all();

        // 選ばれたフォルダを取得する
        // $current_folder = Folder::find($id);
        $tasks = $folder->tasks()->get();

        // if (is_null($current_folder)) {
        //     abort(404);
        // }

        // 選ばれたフォルダに紐づくタスクを取得する
        // $tasks = Task::where('folder_id', $current_folder->id)->get();
        // $tasks = $current_folder->tasks()->get(); // 引数変更によりコメントアウト
        // 下記を上記に書き換え、モデルFolderのhasmanyメソッドの関係性を定義済
        // $tasks = Task::where('folder_id', $current_folder->id)->get();
        // Tasks::where('folder_id', '=', $current_folder->id)->get();
        // 第一引数カラム名、第二引数比較する値
        // where からは QueryBuilder クラスのインスタンスが返っくる。QueryBuilder の get メソッドを呼ぶことで結果の詰まった Collection クラスのインスタンスが返ってくる
        // \App\Task::where('folder_id', 1)->toSql();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }
    /**
     * GET /folders/{id}/tasks/create
     */
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    public function create(Folder $folder, CreateTask $request)
    // 引数二つ int $id変数と、CreateTaskクラスのオブジェクト
    {
        // $current_folder = Folder::find($id);

        $task = new Task();
        // インスタンス化しないと使えない
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        // $current_folder->tasks()->save($task);　
        // dd($current_folder);
        // exit;
        // save モデルをDBに書き込む
        // current_folderに紐づくtasksを登録する
        // メッソッドチェーン tasks()は、Folderクラスで、save()は、Folderクラスの親のModelクラスがもっている。

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            // 'id' => $current_folder->id,
            'folder' => $folder->id,
        ]);
    }

    public function showEditForm(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        // $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->checkRelation($folder, $task);

        // 1
        // $task = Task::find($task_id);

        // 2
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        // 3
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    private function checkRelation(Folder $folder, Task $task)
    {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
