<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = Auth::id();
        return [
            "first_name" => "required|max:30|string",
            "last_name" => "required|max:30|string",
            "email" => "required|email|unique:users,email,".$id,
        ];
    }

    public function messages()
    {
        return [
            "required" => ":attribute bắt buộc phải nhập!",
            "max" => ":attribute tối đa :max kí tự!",
            "string" => ":attribute phải là chuỗi!",
            "email" => ":attribute không đúng định dạng!",
            "unique" => ":attribute đã tồn tại trong hệ thống!",
        ];
    }

    public function attributes()
    {
        return [
            "first_name" => "Tên",
            "last_name" => "Họ",
            "email" => "Email",
        ];
    }
}