<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;
// ★ Authクラスをインポートする
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    // Request、Laravelが持っているClassは、object型になる
    // phpは、オブジェクトはクラス
    // クラスの中で使う変数や、メッソッドが書かれている(オブジェクトは、変数（プロパティ）と関数（メソッド）の集まり）
    // 基本はインスタンス化してクラスを使うが、インスタンス化(static)しなくても使える
    // インスタンス化したものは、アロー演算子を使う
    // インスタンスしないものは、::を使う

    // (Request $request) は、Requestクラスをインスタンス化して$request（変数）に詰め込む　　オブジェクト型でcreateの引数を入れる

    // CreateFolderの親が、Requestクラスになる。
    public function create(CreateFolder $request)
    // public function create(Request $request)
    {
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // $request->titleは、view側のform送信のname属性
        // インスタンスの状態をデータベースに書き込む
        // ★ ユーザーに紐づけて保存
        Auth::user()->folders()->save($folder);

        // 上記で作成した$folderのidをrouteのidに入れる
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
