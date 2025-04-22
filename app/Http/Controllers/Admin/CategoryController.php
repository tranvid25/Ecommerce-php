<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return view('admin.category.index',compact('categories'));
    }
    public function create(){
        return view('admin.category.create');
    }
    public function store(Request $request){
        $data=$request->all();
        if(Category::create($data)){
            return redirect()->route('admin.category.index')->with('success',__('create category successfully'));

        }else{
            return redirect()->back()->withErrors('Failed to create category');
        }
    }
    public function edit(string $id){
        $categories=Category::findOrFail($id);
        return view('admin.category.edit',compact('categories'));
    }
    public function update(Request $request,string $id){
        $categories=Category::findOrFail($id);
        $data=$request->all();
        if($categories->update($data)){
            return redirect()->route('admin.category.index')->with('success',__('update categories successfully'));
        }
        else{
            return redirect()->back()->withErrors('Failed to update category');
        }
    }
    public function destroy(string $id){
        $categories=Category::findOrFail($id);
        $categories->delete();
        return redirect()->route('admin.category.index')->with('success',__('Category delete successfully'));
    }
}
