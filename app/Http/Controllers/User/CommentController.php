<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Admin\Blog;
use App\Models\User\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request) 
    {
        $data = [
            'blog_id' => $request->blog_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'parent_id' => $request->parent_id ?: null,
            'level' => 0,
            'avatar_user' => Auth::user()->avatar ?? 'images/default-avatar.png',
            'name_user' => Auth::user()->name,
            'time' => now(),
        ];
    
        // Tính level nếu là reply
        if (!is_null($data['parent_id'])) {
            $parent = Comment::findOrFail($data['parent_id']);
            $data['level'] = $parent->level + 1;
        }
    
        // Lưu comment mới
        $comment = Comment::create($data);
    
        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }
    
    public function loadComments($blog_id)
{
    $comments = Comment::where('blog_id', $blog_id)
                ->orderBy('time', 'asc')
                ->get();

    $blog = Blog::findOrFail($blog_id); // Lấy blog nếu cần thông tin blog

    return view('frontend.blog.comments', [
        'comments' => $comments,
        'blogs' => $blog // Truyền vào view
    ]);
}

}
