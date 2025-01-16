<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'unique:users,email', 'email', 'max:191'],
            'password' => ['required', 'min:8', 'max:191'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '氏名は必須項目です。f',
            'email.required' => 'アドレスは必須項目です。f',
            'email.email' => '有効なアドレス形式で入力してください。f',
            'email.unique' => 'このアドレスは既に使用されています。f',
            'password.required' => 'パスは必須項目です。f',
            'password.min' => 'パスは8文字以上で入力してください。f',
            'password.confirmed' => 'パスが一致しません。f',
        ];
    }
}
