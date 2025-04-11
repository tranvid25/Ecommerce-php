
@extends('frontend.layout.master')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Blog Details</h2>
                    <div class="single-blog-post">
                        <h3>{{$blogs->title}}</h3>
                        <div class="post-meta">
                            <ul>
                                <li><i class="fa fa-user"></i> Mac Doe</li>
                                <li><i class="fa fa-calendar"></i> {{ date('M d, Y', strtotime($blogs->created_at)) }}</li>
                            </ul>
                        </div>
                       <a href=""><img class="img-fluid " src="{{ asset('upload/user/blog/'.$blogs->image) }}" alt="{{ $blogs->title }}"></a>
                        <p>{!! $blogs->content !!}</p>
                        <div class="rating-area">
                            <ul class="ratings">
                                <li class="rate-this">Rate this item:</li>
                                <li>
                                    <div class="rate">
                                        <div class="vote">
                                            <div class="star_1 ratings_stars"><input value="1" type="hidden"></div>
                                            <div class="star_2 ratings_stars"><input value="2" type="hidden"></div>
                                            <div class="star_3 ratings_stars"><input value="3" type="hidden"></div>
                                            <div class="star_4 ratings_stars"><input value="4" type="hidden"></div>
                                            <div class="star_5 ratings_stars"><input value="5" type="hidden"></div>
                                            <span class="rate-np"></span>
                                        </div> 
                                    </div>
                                </li>
                                <li class="color">(<span id="total-votes">{{ $totalVotes ?? '0' }}</span> votes) - Last rated: <span id="last-rated-time">N/A</span></li>
                            </ul>
                        </div>
                        <div class="pager-area">
                            <ul class="pager pull-right">
                                @if($prevBlog)
                                    <li><a href="{{ route('user.blog.show', $prevBlog->id) }}">Prev</a></li>
                                @endif
                                @if($nextBlog)
                                    <li><a href="{{ route('user.blog.show', $nextBlog->id) }}">Next</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div><!--/blog-post-area-->
                <script>
                    $(document).ready(function () {
                        // CSRF setup 1 lần duy nhất
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                
                        // Hover để đổi màu sao khi rê chuột
                        $('.ratings_stars').hover(
                            function () {
                                $(this).prevAll().addBack().addClass('ratings_hover');
                            },
                            function () {
                                $(this).prevAll().addBack().removeClass('ratings_hover');
                            }
                        );
                
                        // Click để đánh giá
                        $('.ratings_stars').click(function () {
                            var isLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
                
                            if (isLoggedIn === 'true') {
                                var rate = $(this).find("input").val();
                                var blog_id = {{ $blogs->id }};
                
                                $(this).prevAll().addBack().addClass('ratings_over');
                
                                // Gửi AJAX đánh giá
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url("user/rate") }}',
                                    data: {
                                        rate: rate,
                                        blog_id: blog_id
                                    },
                                    success: function (data) {
                                        console.log(data);
                                        $('.rate-np').text(data.average);
                                        $('#total-votes').text(data.votes);
                                        $('#last-rated-time').text(data.time);
                                    },
                                    error: function (xhr) {
                                        console.log(xhr.responseText);
                                        alert("Có lỗi xảy ra khi gửi đánh giá.");
                                    }
                                });
                            } else {
                                alert("Vui lòng đăng nhập để đánh giá.");
                            }
                        });
                    });
                </script>              
                <!--/rating-area--><!--/rating-area-->

                <div class="socials-share">
                    <a href=""><img src="images/blog/socials.png" alt=""></a>
                </div><!--/socials-share-->
                 <!--/Response-area-->
           
                <div class="response-area">
                    <div class="response-area">
                        <!-- Phần comments sẽ được load bằng AJAX -->
                        <div id="comments-wrapper">
                            @include('frontend.blog.comments', ['comments' => $comments ?? []])
                        </div>
                    </div>
                </div>
                 <div class="replay-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Leave a reply</h2>
                            <div class="blank-arrow">
                                <label>{{Auth::user()->name}}</label>
                            </div>
                            <span>*</span>
                            <div class="text-area">
                                <textarea id="comment_content" rows="5" placeholder="Viết bình luận của bạn..."></textarea>
                                <button id="sendComment" class="btn btn-primary" data-blog="{{ $blogs->id }}">Gửi bình luận</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        // CSRF token
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    
                        // ===== Load Comments =====
                        function loadComments(blog_id) {
                            $.ajax({
                                url: '/load-comments/' + blog_id,
                                type: 'GET',
                                success: function(html) {
                                    $('#comments-wrapper').html(html);
                                },
                                error: function(xhr) {
                                    console.log(xhr.responseText);
                                    alert("Có lỗi khi tải bình luận");
                                }
                            });
                        }
                    
                        // ===== Gửi Bình luận Cha =====
                        $('#sendComment').click(function() {
                            var islogin = "{{ Auth::check() ? 'true' : 'false' }}";
                            var blog_id = $(this).data('blog');
                            var comment = $('#comment_content').val(); 
                            
                            if (islogin === 'false') {
                                alert("Vui lòng đăng nhập để bình luận");
                                return;
                            }
                            if (!comment.trim()) {
                                alert("Vui lòng nhập nội dung bình luận");
                                return;
                            }
                    
                            $.ajax({
                                type: 'POST',
                                url: '{{ url("user/comment") }}',
                                data: {
                                    comment: comment,
                                    blog_id: blog_id,
                                    parent_id: 0 // đảm bảo là comment cha
                                },
                                success: function(res) {
                                    $('#comment_content').val('');
                                    loadComments(blog_id);
                                    alert("Bình luận đã được gửi thành công");
                                },
                                error: function(xhr) {
                                    console.log(xhr.responseText);
                                    alert("Có lỗi xảy ra khi gửi bình luận");
                                }
                            });
                        });
                    
                        // ===== Mở Form Trả Lời =====
                        $(document).on('click', '.reply-btn', function() {
                            var parentId = $(this).data('parent');
                            $('.reply-form').hide(); // Ẩn tất cả form khác
                            $('#reply-form-' + parentId).slideToggle(); // Mở đúng form
                        });
                    
                        // ===== Gửi Bình luận Con (Reply) =====
                        $(document).on('click', '.send-reply', function() {
                            var islogin = "{{ Auth::check() ? 'true' : 'false' }}";
                            var blog_id = {{ $blogs->id }};
                            var parent_id = $(this).data('parent');
                            var content = $('#reply-form-' + parent_id).find('.reply-content').val();
                    
                            if (islogin === 'false') {
                                alert("Vui lòng đăng nhập để phản hồi");
                                return;
                            }
                    
                            if (!content.trim()) {
                                alert("Vui lòng nhập phản hồi");
                                return;
                            }
                    
                            $.ajax({
                                type: 'POST',
                                url: '{{ url("user/comment") }}',
                                data: {
                                    comment: content,
                                    blog_id: blog_id,
                                    parent_id: parent_id
                                },
                                success: function(res) {
                                    $('#reply-form-' + parent_id).find('.reply-content').val('');
                                    $('#reply-form-' + parent_id).hide();
                                    loadComments(blog_id);
                                },
                                error: function(xhr) {
                                    console.log(xhr.responseText);
                                    alert("Gửi phản hồi thất bại.");
                                }
                            });
                        });
                    
                        // ===== Load bình luận lần đầu =====
                        loadComments({{ $blogs->id }});
                    });
                </script>
                {{-- Hiển thị bình luận --}}
                
                <!--/Repaly Box-->
            </div>	
        </div>
    </div>
</section>
@endsection