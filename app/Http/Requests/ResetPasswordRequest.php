<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Request;
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
            'token' => 'required',
            'email' => 'required|email',
            // 'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&]).*$/',
            'password' => [
                'required', 
                Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
            'confirm_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute bắt buộc phải nhập!',
            'email' => ':attribute không đúng định dạng!',
            'min' => ':attribute ít nhất :min kí tự!',
            // 'regex' => ':attribute phải chứa ký tự hoa, ký tự thường, số, ký tự đặc biệt!',
            'same' => ':attribute không trùng khớp!',
            'token.required' => 'Không tồn tại token!',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'confirm_password' => 'Mật khẩu xác nhận', 
        ];
    }
}