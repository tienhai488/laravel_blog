<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'max:30',
                'string',
            ],
            'last_name' => [
                'required',
                'max:30',
                'string',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users,email',
            ],
            'password' => [
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
            'max' => ':attribute tối đa :max kí tự!',
            'min' => ':attribute ít nhất :min kí tự!',
            'string' => ':attribute phải là chuỗi!',
            'email' => ':attribute không đúng định dạng!',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
            'confirmed' => ':attribute xác nhận không trùng khớp!',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'Tên',
            'last_name' => 'Họ',
            'email' => 'Email',
            'password' => 'Mật khẩu',
        ];
    }
}
