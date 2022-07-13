<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


  // ->name ルーティングに名前をつけて保存することができる viewので、リンクを
  // {id} クエリパラメータのような使用方法　TaskControllerクラスのindexメッソッドを実行する→controllerクラスをコマンドで作成する


Route::group(['middleware' => 'auth'], function() {
  Route::get('/', 'HomeController@index')->name('home');

  Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');

  Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
  Route::post('/folders/create', 'FolderController@create');

  Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
  Route::post('/folders/{id}/tasks/create', 'TaskController@create');

  Route::get('/folders/{id}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');
  Route::post('/folders/{id}/tasks/{task_id}/edit', 'TaskController@edit');
});

Auth::routes();

/// ログインした後のリダイレクト先
// Http/Auth/LoginController.php
// ユーザー登録の時のリダイレクト先
// Http/Auth/RegisterController.php

// 以下グループで、処理を分ける
// ログインしているときに見れないページにアクセスした時のリダイレクト先(Laravelで用意しているユーザー登録画面 /register,/loginにアクセスした場合)
// middleware/RedirectIfAuthenticated.php
// ログインしてない状態で、ログインしている時の画面 return root login
// middleware/Authenticate.php
// 存在しないページにアクセスした場合は、404error