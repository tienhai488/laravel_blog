<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required",
        ];
    }

    public function messages()
    {
        return [
            "required" => ":attribute bắt buộc phải nhập!",
            "email" => ":attribute không đúng định dạng!",
            "min" => ":attribute ít nhất :min kí tự!",
        ];
    }

    public function attributes()
    {
        return [
            "email" => "Email",
            "password" => "Mật khẩu",
        ];
    }
}