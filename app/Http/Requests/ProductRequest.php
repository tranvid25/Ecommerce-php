<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0|lt:price',
            'status' => 'required|in:0,1',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'company' => 'required|string|max:255',
            'images' => 'required|array|max:3', // kiểm tra input images trong form (dù không lưu vào DB)
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:1024',
            'detail' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'name.string' => 'Tên sản phẩm không hợp lệ.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',

            'sale.numeric' => 'Giá khuyến mãi phải là số.',
            'sale.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'sale.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',

            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại.',

            'brand_id.required' => 'Vui lòng chọn thương hiệu.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',

            'company.required' => 'Vui lòng nhập tên công ty.',
            'company.max' => 'Tên công ty không được vượt quá 255 ký tự.',

            'images.required' => 'Vui lòng chọn tối đa 3 hình ảnh.',
            'images.array' => 'Hình ảnh không hợp lệ.',
            'images.max' => 'Chỉ được chọn tối đa 3 hình ảnh.',
            'images.*.image' => 'Mỗi file phải là hình ảnh.',
            'images.*.mimes' => 'Chỉ chấp nhận các định dạng jpeg, jpg, png, gif.',
            'images.*.max' => 'Mỗi ảnh không được vượt quá 1MB.',

            'detail.required' => 'Vui lòng nhập mô tả chi tiết.',
            'detail.max' => 'Mô tả không được vượt quá 1000 ký tự.',
        ];
    }
}
