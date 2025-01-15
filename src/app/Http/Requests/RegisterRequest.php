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
            'name.required' => '名前は必須項目です。f',
            'email.required' => 'メールアドレスは必須項目です。f',
            'email.email' => '有効なメールアドレス形式で入力してください。f',
            'email.unique' => 'このメールアドレスは既に使用されています。f',
            'password.required' => 'パスワードは必須項目です。f',
            'password.min' => 'パスワードは8文字以上で入力してください。f',
            'password.confirmed' => 'パスワードが一致しません。f',
        ];
    }
}
