<?php

namespace App\Http\Requests;

use App\Rules\UserStatusRule;
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
        $rules = [
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
                'max:100',
                'unique:users,email,' . $id,
            ],
            'address' => [
                'max:255',
            ],
        ];

        if (request()->routeIs('admin.users.post_edit')) {
            $rules['status'] = [new UserStatusRule];
            $rules['email'] = [
                'required',
                'email',
                'max:100',
                'unique:users,email,' . $this->user->id
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute bắt buộc phải nhập!',
            'max' => ':attribute tối đa :max kí tự!',
            'string' => ':attribute phải là chuỗi!',
            'email' => ':attribute không đúng định dạng!',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'Tên',
            'last_name' => 'Họ',
            'email' => 'Email',
            'address' => 'Địa chỉ',
            'status' => 'Địa ',
        ];
    }
}
