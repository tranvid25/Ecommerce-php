@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="container">
        <h2 class="mb-3">Chỉnh sửa bài viết</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.blog.update', $blogs->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
             @method('PUT')

            <div class="mb-3">
                <label>Tiêu đề:</label>
                <input type="text" name="title" class="form-control" value="{{ $blogs->title }}" required>
            </div>

            <div class="mb-3">
                <label>Hình ảnh:</label>
                <input type="file" name="image" class="form-control">
                @if ($blogs->image)
                    <img src="{{ asset('upload/user/blog/' . $blogs->image) }}" width="100">
                @endif
            </div>

            <div class="mb-3">
                <label>Mô tả:</label>
                <input type="text" name="description" class="form-control" value="{{ $blogs->description }}">
            </div>

            <div class="mb-3">
                <label>Nội dung:</label>
                <textarea name="content" id="editor1" class="form-control">{{ $blogs->content }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: "{{ asset('ckfinder/ckfinder.html') }}",
            filebrowserImageBrowseUrl: "{{ asset('ckfinder/ckfinder.html?type=Images') }}",
            filebrowserFlashBrowseUrl: "{{ asset('ckfinder/ckfinder.html?type=Flash') }}",
            filebrowserUploadUrl: "{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
            filebrowserImageUploadUrl: "{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}",
            filebrowserFlashUploadUrl: "{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}"
        });
    </script>
</div>
@endsection
