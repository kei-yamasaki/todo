<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // リクエストの内容に基づいた権限チェックのために使う
    public function authorize()
    {
        // 使用しないのでtrue(リクエストを受け付ける)
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
            'title' => 'required|max:20',
            // input要素のname属性
        ];
    }

    public function attributes()
{
    return [
        'title' => 'フォルダ名',
    ];
}
}
