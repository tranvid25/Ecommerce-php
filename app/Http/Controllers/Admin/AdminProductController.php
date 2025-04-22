<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $products=Product::all();
        return view('admin.product.index',compact('products'));
    }
    public function destroy(string $id){
        $products=Product::findOrFail($id);
        $products->delete();
        return redirect()->route('admin.product.index')->with('success','xóa sản phẩm thành công');
    }
}
