<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "first_name" => "required|max:30|string",
            "last_name" => "required|max:30|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&]).*$/",
            "confirm_password" => "required|same:password",
        ];
    }

    public function messages()
    {
        return [
            "required" => ":attribute bắt buộc phải nhập!",
            "max" => ":attribute tối đa :max kí tự!",
            "min" => ":attribute ít nhất :min kí tự!",
            "string" => ":attribute phải là chuỗi!",
            "email" => ":attribute không đúng định dạng email!",
            "unique" => ":attribute đã tồn tại trong hệ thống!",
            "regex" => ":attribute phải chứa ký tự hoa, ký tự thường, số, ký tự đặc biệt!",
            "same" => ":attribute không trùng khớp!",
        ];
    }

    public function attributes()
    {
        return [
            "first_name" => "Tên",
            "last_name" => "Họ",
            "email" => "Email",
            "password" => "Mật khẩu",
            "confirm_password" => "Mật khẩu xác nhận", 
        ];
    }
}