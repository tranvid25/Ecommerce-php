<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           
                'blog_id' => 'required|exists:blogs,id', // Kiểm tra blog_id có tồn tại trong bảng blogs
                'rate' => 'required|integer|min:1|max:5', // Kiểm tra rate trong phạm vi từ 1 đến 5
            
        ];
    }
}
