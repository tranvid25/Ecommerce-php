@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="container">
        <h2 class="mb-3">Quản lý Product</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    @php
                        $images = json_decode($product->hinhanh, true);
                    @endphp
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>
                            @if (!empty($images))
                                <img src="{{ asset('upload/product/' . $images[0]) }}" width="100">
                            @else
                                <span>Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ number_format($product->price) }} VNĐ</td>
                        <td>
                            <form action="{{route('admin.product.destroy',$product->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn xóa?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
