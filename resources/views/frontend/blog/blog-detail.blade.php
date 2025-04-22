
@extends('frontend.layout.master')
@include('frontend.layout.menu-left');
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
                            <ul class="ratings list-unstyled">
                                <li class="rate-this" style="margin-top: 20px">Rate this item:</li>
                                <li>
                                    <div class="rate" >
                                        <div class="vote">
                                            @for($count = 1; $count <= 5; $count++)
                                                @php
                                                    $color = ($count <= ($userRating ?? $rating ?? 0)) ? 'color:#ffcc09;' : 'color:#ccc;';
                                                @endphp
                                                <span class="star-rating"
                                                    style="{{ $color }} cursor:pointer; font-size:30px;"
                                                    data-index="{{ $count }}" 
                                                    data-blog_id="{{ $blogs->id }}"
                                                    data-user_rating="{{ $userRating ?? 0 }}">
                                                    ★
                                                </span>
                                            
                                            @endfor
                                           
                                                <span class="rate-np" style="margin-top:15px" >{{ round($userRating ?? $rating ?? 0, 1) }}</span>
                                                (<span id="total-votes"
                                                style="margin-bottom:5px">{{ $totalVotes ?? 0 }}</span> votes)</div>
                                            
                                           
                                           
                                            <!-- 👇 Gộp điểm và votes tại đây -->
                                
                                        </div>
                                     
                                </li>
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
                    $(document).ready(function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    
                        let rated = false;
                    
                        // Hover hiệu ứng màu
                        $(document).on('mouseenter', '.star-rating', function () {
                            let index = parseInt($(this).data('index'));
                            $('.star-rating').each(function () {
                                $(this).css('color', parseInt($(this).data('index')) <= index ? '#ffcc09' : '#ccc');
                            });
                        });
                    
                        // Trả lại màu sau khi rời chuột
                        $(document).on('mouseleave', '.star-rating', function () {
                            let userRating = parseInt($('.star-rating').first().attr('data-user_rating')); // fix ở đây
                            $('.star-rating').each(function () {
                                $(this).css('color', parseInt($(this).data('index')) <= userRating ? '#ffcc09' : '#ccc');
                            });
                        });
                    
                        // Click đánh giá
                        $(document).on('click', '.star-rating', function () {
                            if (rated) return;
                    
                            let index = $(this).data('index');
                            let blog_id = $(this).data('blog_id');
                    
                            $.ajax({
                                url: '{{ url("user/rate") }}',
                                method: "POST",
                                data: {
                                    rate: index,
                                    blog_id: blog_id,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function (response) {
                                    rated = true;
                    
                                    const newRating = response.user_rate;
                    
                                    // Cập nhật lại user_rating và tô màu
                                    $('.star-rating').each(function () {
                                        $(this).attr('data-user_rating', newRating);
                                        let i = $(this).data('index');
                                        $(this).css('color', i <= newRating ? '#ffcc09' : '#ccc');
                                    });
                    
                                    // Cập nhật điểm trung bình và số vote
                                    $('.rate-np').text(response.average);
                                    $('#total-votes').text(response.votes);
                    
                                    alert(response.message);
                                }
                            });
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