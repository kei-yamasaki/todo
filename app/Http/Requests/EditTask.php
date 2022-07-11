<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{
    public function rules()
    {
        $rule = parent::rules();
        // parentは、親クラスCreateTaskクラスのメソッドを指定

        $status_rule = Rule::in(array_keys(Task::STATUS));
        // Rouleクラスのinメソッド -> 'in(1, 2, 3)' を出力する
        // array_keysメソッド連想配列のkeyを返す関数
        // 'status' => 'required|in(1, 2, 3)'
        // 状態を表すバリデーション

        return $rule + [
            'status' => 'required|' . $status_rule,
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        $messages = parent::messages();

        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);
        // array_map 指定した全ての配列に同じ処理をする
        // 第二引数STATUS配列に対して、第一引数は、実行したい処理
        // 'label'というkeyに紐づくvalueを全て取得する

        // 未着手、着手中、完了
        $status_labels = implode('、', $status_labels);
        // 指定した配列の値を指定した文字列の値で区切る
        // 第一引数は、区切り文字、第二引数は、区切りたい配列

        // 状態には、未着手、着手中、完了のいずれかを指定してください。
        return $messages + [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
            //statusのinルールに違反したときは、次の処理をする
        ];
    }
}