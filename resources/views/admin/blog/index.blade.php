@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="container">
        <h2 class="mb-3">Quản lý Blog</h2>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary mb-3">Thêm bài viết</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>Nội dung</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->title }}</td>
                        <td>
                            @if ($blog->image)
                                <img src="{{ asset('upload/user/blog/' . $blog->image) }}" width="100">
                            @endif
                        </td>
                        <td>{{ $blog->description}}</td>
                        <td>{!! Str::limit($blog->content, 50) !!}</td>
                        <td>
                            <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-warning">Sửa</a>
                            <a href="{{ route('admin.blog.show', $blog->id) }}" class="btn btn-info">Xem</a>
                            <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa bài viết này?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
