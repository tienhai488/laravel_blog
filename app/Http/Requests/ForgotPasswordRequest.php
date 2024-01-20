<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|exists:users",
        ];
    }

    public function messages()
    {
        return [
            "required" => ":attribute bắt buộc phải nhập!",
            "email" => ":attribute không đúng định dạng!",
            "exists" => ":attribute không tồn tại trong hệ thống!",
        ];
    }

    public function attributes()
    {
        return [
            "email" => "Email",
        ];
    }
}