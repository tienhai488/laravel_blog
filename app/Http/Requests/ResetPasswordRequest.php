<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => [
                'required'
            ],
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed'
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute bắt buộc phải nhập!',
            'email' => ':attribute không đúng định dạng!',
            'min' => ':attribute ít nhất :min kí tự!',
            'confirmed' => ':attribute xác nhận không trùng khớp!',
            'token.required' => 'Không tồn tại token!',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu',
        ];
    }
}
