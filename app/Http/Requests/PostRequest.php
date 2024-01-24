<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => "required|string|max:100|unique:posts",
            'slug' => "required|string|max:100|unique:posts",
            'description' => "string|max:200",
            'content' => "required|string",
            'thumbnail' => "required",
        ];

        if(request()->routeIs("posts.update")){
            $rules["title"] = "required|string|max:100|unique:posts,title,".$this->post->id;
            $rules["slug"] = "required|string|max:100|unique:posts,slug,".$this->post->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute bắt buộc phải nhập!',
            'string' => ':attribute phải là chuỗi!',
            'max' => ':attribute tối đa :max kí tự!',
            'unique' => ':attribute đã tồn tại!',
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