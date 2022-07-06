<?php

// formごとにバリデーションを作成する
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // viewに書かれたname属性 'title','due_data'
            'title' => 'required|max:100',
            'due_date' => 'required|date|after_or_equal:today',
            // date 日付の形式
            // after_or_equal:todya 今日を含む特定の日付と同じまたはそれ以降の日付
        ];
    }

    public function attributes()
    // バリデーションで表示されるname属性を以下に変更する
    {
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    public function messages()
    {
        return [
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
            // 一般的なルールについては validation.php に記述するが、messages メソッドでは個別の FormRequest クラスの内部でのみ有効なメッセージを定義できる
        ];
    }
}