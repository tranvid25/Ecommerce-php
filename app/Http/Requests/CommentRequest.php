<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép request này luôn chạy
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|min:1|max:1000',
            'blog_id' => 'required|exists:blogs,id',
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'Bạn chưa nhập nội dung bình luận.',
            'comment.min' => 'Bình luận quá ngắn (tối thiểu 3 ký tự).',
            'blog_id.required' => 'Thiếu thông tin bài viết.',
            'blog_id.exists' => 'Bài viết không tồn tại.',
        ];
    }
}
