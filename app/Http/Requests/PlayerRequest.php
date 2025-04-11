<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
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
          'name'=>'required|max:191',
          'age' => 'required|integer|min:16|max:50',
          'nation' => 'required|string|max:100',
          'position' => 'required|string|max:50',
          'salary' => 'required|numeric|min:0|max:9999999999.99', 
        ];
    }
    public function messages()
{
    return [
        'required' => ':attribute không được để trống.',
        'string' => ':attribute phải là chuỗi ký tự.',
        'max' => ':attribute không được vượt quá :max ký tự.',
        'min' => ':attribute không được nhỏ hơn :min.',
        'integer' => ':attribute phải là số nguyên.',
        'numeric' => ':attribute phải là số.',
        'salary.max' => 'Lương không được vượt quá giới hạn cho phép.',
    ];
}

}
