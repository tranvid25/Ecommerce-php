<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addCart(Request $request){
        $productId=$request->id;
        $cart=session()->get('cart',[]);
        if(isset($cart[$productId])){
            $cart[$productId]['quantity']+=1;
        }else{
            $product=Product::findOrFail($productId);
            if(!$product){
                return response()->json([
                    'error'=>'Sản phẩm không tồn tại'
                ],404);
            }
            $cart[$productId]=[
                "hinhanh"=>$product->hinhanh,
                "name"=>$product->name,
                "price"=>$product->price,
                "Id"=>$product->id,
                "quantity"=>1
            ];
        }
        session()->put('cart',$cart);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalPrice=0;
        foreach($cart as $item){
            $totalPrice+=$item['price']*$item['quantity'];
        }
        return response()->json([
            'count' => $totalQuantity,
            'total' => $totalPrice
        ]);
    }
    public function viewCart(){
        $cart = session()->get('cart', []);
        $total = 0;
    foreach($cart as $item){
        $total += $item['price'] * $item['quantity'];
    }

        return view('frontend.cart.cart',compact('cart','total'));
    }
    public function update(Request $request){
        $productId=$request->id;//lấy từ ajax
        $action=$request->action;//lấy từ ajax
        $cart=session()->get('cart',[]);
        if(isset($cart[$productId])){
            $product=$cart[$productId];
            if($action=='tang'){
                $product['quantity']++;
            }elseif($action=='giam' && $product['quantity']>1){
                $product['quantity']--;
            }
            $cart[$productId] = $product;
            session()->put('cart',$cart);
            $new_quantity=$product['quantity'];
            $new_total=$product['quantity']*$product['price'];
            $totalCart=0;
            foreach($cart as $item){
              $totalCart+=$item['quantity']*$item['price'];
            }
            return response()->json([
                'new_quantity'=>$new_quantity,
                'new_total'=>$new_total,
                'product_id'=>$productId,
                'cart_total' => $totalCart
            ]);
        }
        return response()->json(['message' => 'Sản phẩm không tồn tại trong giỏ hàng'], 400);
    }
    public function delete(Request $request){
        $productId=$request->id;
        $cart=session()->get('cart',[]);
        if(isset($cart[$productId])){
            unset($cart[$productId]);
            session()->put('cart',$cart);
            $totalCart=0;
            foreach($cart as $item){
                $totalCart+=$item['price']*$item['quantity'];
            }
            return response()->json([
                'message'=>'Xóa thành công',
                'cart_total'=>$totalCart
            ]);
        }
        return response()->json(['message' => 'Sản phẩm không tồn tại trong giỏ hàng'], 400);
    }
}
