<?php

namespace App\Http\Requests;

use App\Rules\CheckPasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password_old' => [
                'required',
                new CheckPasswordRule,
            ],
            'password_new' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute bắt buộc phải nhập!',
            'min' => ':attribute ít nhất :min kí tự!',
            'confirmed' => ':attribute xác nhận không trùng khớp!',
        ];
    }

    public function attributes()
    {
        return [
            'password_old' => 'Mật khẩu',
            'password_new' => 'Mật khẩu mới',
        ];
    }
}
