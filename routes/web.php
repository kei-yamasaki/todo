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
Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');

// アクセスした時の処理と、ポスト送信した時の処理をリクエストにより分ける
// controllerクラスでfolder作成ページへアクセスするときに、nameを使う
Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
Route::post('/folders/create', 'FolderController@create');

Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
Route::post('/folders/{id}/tasks/create', 'TaskController@create');

Route::get('/folders/{id}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');
Route::post('/folders/{id}/tasks/{task_id}/edit', 'TaskController@edit');

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();