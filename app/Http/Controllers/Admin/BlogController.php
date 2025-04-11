<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Admin\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $blogs=Blog::all();
        return view('admin.blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $data=$request->all();
        $file=$request->image;
        if(!empty($file)){
            $data['image']=$file->getClientOriginalName();
        }
        if(Blog::create($data)){
            if(!empty($file)){
                $file->move('upload/user/blog',$file->getClientOriginalName());
            }
            return redirect()->route('admin.blog.index')->with('success',__('Blog created successfully'));
        }
        else{
            return redirect()->back()->withErrors('Failed to create blog');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogs=Blog::findOrFail($id);
        return view('admin.blog.show',compact('blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blogs=Blog::findOrFail($id);
        return view('admin.blog.edit',compact('blogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $blogs=Blog::findOrFail($id);
        $data=$request->all();
        $file=$request->image;

        if(!empty($file)){
            $data['image']=$file->getClientOriginalName();
        }
        else{
            $data['image']=$blogs->image;
        }
        if($blogs->update($data)){
            if(!empty($file)){
                $file->move('upload/user/blog',$file->getClientOriginalName());
            }
            return redirect()->route('admin.blog.index')->with('success',__('Blog updated successfully'));
        }else{
            return redirect()->back()->withErrors('Failed to update blog.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blogs=Blog::findOrFail($id);
        $blogs->delete();
        return redirect()->route('admin.blog.index')->with('success',__('Blog deleted successfully'));
    }
}
