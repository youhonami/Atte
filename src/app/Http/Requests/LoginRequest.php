<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:191'],
            'password' => ['required', 'min:8', 'max:191'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'アドレスは必須項目です。',
            'email.email' => '有効なアドレス形式で入力してください。',
            'password.required' => 'パスは必須項目です。',
            'password.min' => 'パスは8文字以上で入力してください。',
        ];
    }
}
