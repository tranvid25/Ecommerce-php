<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;



class ProductController extends Controller
{
    
    public function index()
{
    $products = Product::where('id_user', Auth::id())->latest()->get();
    return view('frontend.product.my-product', compact('products'));
}
    public function show(string $id){
        $products=Product::findOrFail($id);
        return view('frontend.product.detail',compact('products'));
    }

    public function create(){
        $categories=Category::all();
        $brands=Brand::all();
        return view('frontend.product.add-product',compact('categories','brands'));
    }
    public function store(ProductRequest $request)
{
    $imageNames = [];
   //images[] dùng để người dùng upload ảnh vào 
   
    if ($request->hasFile('images')) {
        //laravel sẽ nhận ảnh người dung upload  từ images[] qa đây
        $images = $request->file('images');

        if (count($images) > 3) {
            return back()->with('error', 'Chỉ được upload tối đa 3 hình.');
        }

        foreach ($images as $image) {
            if (!$image->isValid() || $image->getSize() > 1024 * 1024) {
                continue; // bỏ qua ảnh lỗi hoặc >1MB
            }
            //lấy đuôi tên đuôi file gốc
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $basePath = public_path('upload/product/');

            // Resize & lưu
            Image::make($image)->save($basePath . $name);
            Image::make($image)->resize(85, 84)->save($basePath . 'hinh50_' . $name);
            Image::make($image)->resize(329, 380)->save($basePath . 'hinh200_' . $name);

            $imageNames[] = $name;
        }
    }

    Product::create([
        'id_user'     => Auth::id(),
        'name'        => $request->name,
        'price'       => $request->price,
        'category_id' => $request->category_id,
        'brand_id'    => $request->brand_id,
        'status'      => $request->status,
        'sale'        => $request->status == 1 ? $request->sale : null,
        'company'     => $request->company,
        'hinhanh'     => json_encode($imageNames),
        'detail'      => $request->detail,
    ]);

    return redirect()->route('frontend.product.my-product')->with('success', 'Thêm sản phẩm thành công!');
}
public function edit(string $id){
    $categories=Category::all();
    $brands=Brand::all();
    $products=Product::findOrFail($id);
    return view('frontend.product.edit',compact('products','categories','brands'));
}
public function update(Request $request,string $id){
    $products=Product::findOrFail($id);
    $hinhcu=json_decode($products->hinhanh,true);//hình cũ vd:[1,2,3]
    $hinhxoa=$request->input('hinhanhxoa',[]);
    foreach($hinhxoa as $hinh){
        if(in_array($hinh,$hinhcu)){
            $index=array_search($hinh,$hinhcu);
            if($index !== false){
                unset($hinhcu[$index]);
                @unlink(public_path('upload/product/' . $hinh));
                @unlink(public_path('upload/product/hinh50_' . $hinh));
                @unlink(public_path('upload/product/hinh200_' . $hinh));
            }
        }
    }
    $hinhconlai=array_values($hinhcu);
    //có thể là [1,3]//lọc những ảnh cũ đã xóa với ảnh còn lại thì vd là[2]
    $hinhanhmoi=[];
    if($request->hasFile('hinhanhmoi')){
        foreach($request->file('hinhanhmoi') as $file){
            if (!$file->isValid() || $file->getSize() > 1024 * 1024) {
                continue; // bỏ qua ảnh lỗi hoặc >1MB
            }
            $name=time() . '_' . uniqid() . '.' .$file->getClientOriginalExtension();
            $basePath=public_path('upload/product/');
            Image::make($file)->save($basePath.$name);
            Image::make($file)->resize(85,84)->save($basePath . 'hinh50_' .$name);
            Image::make($file)->resize(329,380)->save($basePath . 'hinh200_' .$name);
            $hinhanhmoi[]=$name;
        }
    }
    //Tổng số ảnh không vượt quá 3
    if(count($hinhanhmoi)+count($hinhconlai)>3){
        return back()->with('error','Tối đa 3 hình ảnh!');
    }
    $hinhtong=array_merge($hinhconlai,$hinhanhmoi);
    $products->update([
        'id_user' => Auth::id(),
        'name'    => $request->name,
        'price'   => $request->price,
        'category_id' =>$request->category_id,
        'brand_id'=>$request->brand_id,
        'status'  =>$request->status,
        'sale'    =>$request->status==1 ? $request->sale : null,
        'company' =>$request->company,
        'hinhanh' =>json_encode($hinhtong),
        'detail'  =>$request->detail,
    ]);
    return redirect()->route('frontend.product.my-product')->with('success','Cập nhật sản phẩm thành công');
}
public function destroy(string $id){
    $products=Product::findOrFail($id);
    $products->delete();
    return redirect()->route('frontend.product.my-product')->with('success','Xóa sản phẩm thành công');
}
public function search(Request $request)
{
    $products = Product::query();

    if ($request->filled('search')) {
        $products->where('name', 'LIKE', '%' . $request->search . '%');
    }

    if ($request->filled('name')) {
        $products->where('name', 'LIKE', '%' . $request->name . '%');
    }

    if ($request->filled('price_range')) {
        switch ($request->price_range) {
            case '1':
                $products->whereBetween('price', [0, 100]);
                break;
            case '2':
                $products->whereBetween('price', [100, 300]);
                break;
            case '3':
                $products->whereBetween('price', [300, 500]);
                break;
            case '4':
                $products->where('price', '>=', 500);
                break;
        }
    }
    // Filtrage par min_price et max_price (slider)

    if ($request->filled('category')) {
        $products->where('category_id', $request->category);
    }

    if ($request->filled('brand')) {
        $products->where('brand_id', $request->brand);
    }

    if ($request->filled('status')) {
        $products->where('status', $request->status);
    }

    $products = $products->paginate(9);

    $categories = Category::all();
    $brands = Brand::all();

    // Vérifier si c'est une requête AJAX
    return view('frontend.product.search', compact('products', 'categories', 'brands'));
}
public function getProducts(Request $request)
{
    $minPrice = $request->min_price ?? 0;
    $maxPrice = $request->max_price ?? 5000;

    $products = Product::whereBetween('price', [$minPrice, $maxPrice])->get();                                                                                                                                                                                                                                                                                                                                                                                      

    return response()->json($products);
}
}
