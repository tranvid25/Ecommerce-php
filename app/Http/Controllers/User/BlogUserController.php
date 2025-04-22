<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blog;
use App\Models\Admin\Rate;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class BlogUserController extends Controller
{
    public function index(){
        $blogs=Blog::orderBy('created_at','desc')->paginate(3);
        return view('frontend.blog.blog',compact('blogs'));
    }
    public function show(string $id)
{
    $blogs = Blog::findOrFail($id);
    
    // Thiếu check rating của user hiện tại
    $userRating = auth()->check() 
        ? Rate::where('user_id', auth()->id())
             ->where('blog_id', $blogs->id)
             ->value('rate')
        : null;
    
    $rating = round(Rate::where('blog_id', $blogs->id)->avg('rate'));
    $totalVotes = Rate::where('blog_id', $blogs->id)->count();
    
    $prevBlog = Blog::where('id', '<', $id)->orderBy('id', 'desc')->first();
    $nextBlog = Blog::where('id', '>', $id)->orderBy('id', 'asc')->first();
    
    return view('frontend.blog.blog-detail', compact(
        'blogs',
        'prevBlog',
        'nextBlog',
        'rating',
        'totalVotes',
        'userRating' // Thêm biến này
    ));
}
    


}
