<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blog;
use Illuminate\Http\Request;

class BlogUserController extends Controller
{
    public function index(){
        $blogs=Blog::orderBy('created_at','desc')->paginate(3);
        return view('frontend.blog.blog',compact('blogs'));
    }
    public function show(string $id){
        $blogs=Blog::findOrFail($id);
        $prevBlog = Blog::where('id', '<', $id)->orderBy('id', 'desc')->first();// nhăn prev nó sẽ tìm bài viết trc 5
        $nextBlog = Blog::where('id', '>', $id)->orderBy('id', 'asc')->first(); //nhắn next nó sẽ tìm bài viết sau 5
        return view('frontend.blog.blog-detail',compact('blogs','prevBlog','nextBlog'));
    }
}
