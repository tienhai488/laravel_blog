<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => "required|string|max:100",
            'slug' => "required|string|max:100",
            'description' => "string|max:200",
            'content' => "required|string",
            'thumbnail' => "required",
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute bắt buộc phải nhập!',
            'string' => ':attribute phải là chuỗi!',
            'max' => ':attribute tối đa :max kí tự!',
            'thumbnail.required' => 'Vui lòng chọn hình ảnh cho bài viết!',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
            'slug' => 'Slug',
            'description' => 'Mô tả',
            'content' => 'Nội dung',
        ];
    }
}