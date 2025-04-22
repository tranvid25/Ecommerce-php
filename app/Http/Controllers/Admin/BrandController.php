<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Intervention\Image\Colors\Rgb\Channels\Red;
use Spatie\Backtrace\Arguments\ReducedArgument\ReducedArgument;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $brands=Brand::all();
        return view('admin.brand.index',compact('brands'));
    }
    public function create(){
        return view('admin.brand.create');
    }
    public function store(Request $request){
        $data=$request->all();
        if(Brand::create($data)){
            return redirect()->route('admin.brand.index')->with('success',__('Brand create successfully'));
        }
        else{
            return redirect()->back()->withErrors('Failed to create brand');
        }
    }
    public function edit(string $id){
        $brands=Brand::findOrFail($id);
        return view ('admin.brand.edit',compact('brands'));
    }
    public function update(Request $request, string $id){
        $brands=Brand::findOrFail($id);
        $data=$request->all();
        if($brands->update($data)){
            return redirect()->route('admin.brand.index')->with('success',__('update brand successfully'));
        }
        else{
            return redirect()->back()->withErrors('Failed to update brand');
        }
    }
    public function destroy(string $id){
        $brands=Brand::findOrFaill($id);
        $brands->delete();
        return redirect()->route('admin.brand.index')->with('success',__('Brand deleted successfully'));
    }
}
