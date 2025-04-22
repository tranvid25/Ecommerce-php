@extends('admin.layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="container">
        <h2 class="mb-3">Quản lý Blog</h2>
        <a href="{{ route('admin.brand.create') }}" class="btn btn-primary mb-3">Thêm Brand mới</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->name}}</td>
                        <td>
                            <a href="{{ route('admin.brand.edit', $brand->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa Brand này ?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection