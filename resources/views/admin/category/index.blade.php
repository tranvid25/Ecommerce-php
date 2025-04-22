@extends('admin.layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="container">
        <h2 class="mb-3">Quản lý Category</h2>
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary mb-3">Thêm Category mới</a>

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
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name}}</td>
                        <td>
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa category này ?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection