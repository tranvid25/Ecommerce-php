@extends('frontend.layout.master')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Latest From Our Blog</h2>
                    @foreach($blogs as $blog)
                        <div class="single-blog-post">
                            <!-- Tiêu đề -->
                            <h3>{{ $blog->title }}</h3>

                            <!-- Thông tin bài viết -->
                            <div class="post-meta">
                                <ul>
                                    <li><i class="fa fa-user"></i> Admin</li>
                                    <li><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d M, Y') }}</li>
                                </ul>
                            </div>

                            <!-- Ảnh đại diện -->
                            <a href="{{ route('user.blog.show', $blog->id) }}">
                                <img class="img-fluid " src="{{ asset('upload/user/blog/'.$blog->image) }}" alt="{{ $blog->title }}">
                            </a>

                            <!-- Mô tả ngắn -->
                            <p>{{ Str::limit($blog->des, 150) }}</p>

                            <!-- Nút Read More -->
                            <a class="btn btn-primary" href="{{ route('user.blog.show', $blog->id) }}">
                                Read More <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach

                    <!-- Phân trang -->
                    <div class="pagination-area text-center">
                        {{ $blogs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
