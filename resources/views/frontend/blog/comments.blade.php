<ul class="media-list" id="comment-list">
    @foreach ($comments as $comment)
        @if ($comment->level == 0)
            <li class="media mb-4">
                <a class="pull-left me-3" href="#">
                    <img class="media-object rounded-circle" src="{{ asset('upload/user/avatar/' . $comment->avatar_user) }}" width="60" height="60" alt="avatar">
                </a>
                <div class="media-body">
                    <ul class="sinlge-post-meta mb-1">
                        <li><i class="fa fa-user"></i> {{ $comment->name_user }}</li>
                        <li><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($comment->created_at)->format('H:i') }}</li>
                        <li><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y') }}</li>
                    </ul>
                    <p class="mb-2">{{ $comment->comment }}</p>
                    
                    {{-- Nút trả lời --}}
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary  reply-btn" style="margin-right: 20px" data-parent="{{ $comment->id }}">
                        <i class="fa fa-reply"></i> Trả lời
                    </a>

                    {{-- Form trả lời ẩn --}}
                    <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
                        <textarea class="form-control reply-content" id="reply-content-{{ $comment->id }}" rows="2" placeholder="Nhập phản hồi..."></textarea>
                        <button class="btn btn-sm btn-success mt-2 send-reply"
                                data-parent="{{ $comment->id }}"
                                data-blog="{{ $blogs->id }}">
                            Gửi phản hồi
                        </button>
                    </div>

                    {{-- Danh sách reply --}}
                    <ul class="media-list replies mt-3 ps-4" >
                        @foreach ($comments->where('parent_id', $comment->id) as $reply)
                            <li class="media mb-3">
                                <a class="pull-left me-3" href="#">
                                    <img class="media-object rounded-circle" src="{{ asset('upload/user/avatar/' .$reply->avatar_user) }}" width="60" height="60" alt="avatar">
                                </a>
                                <div class="media-body">
                                    <ul class="sinlge-post-meta mb-1">
                                        <li><i class="fa fa-user"></i> {{ $reply->name_user }}</li>
                                        <li><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($reply->created_at)->format('H:i') }}</li>
                                        <li><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($reply->created_at)->format('d/m/Y') }}</li>
                                    </ul>
                                    <p>{{ $reply->comment }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @endif
    @endforeach
</ul>
