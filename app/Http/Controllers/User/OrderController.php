<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\Notify;
use App\Models\User;
use App\Models\User\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\password;

class OrderController extends Controller
{
    public function index(){
        $cart=session('cart',[]);
        return view('frontend.checkout.checkout',compact('cart'));
    }
    public function placeOrder(Request $request){
       if(!Auth::check()){
        return redirect()->route('order.form')->with('error','Vui lòng đăng nhập để tiếp tục');
       } 
       $user=Auth()->user();
       $cart=session('cart',[]);
       if(empty($cart)){
        return redirect()->back()->with('error','Giỏ hàng của bạn hiện tại ko có');
       }
       $total=collect($cart)->sum(fn($item)=>$item['price']*$item['quantity']);
       History::create([
        'email'=>$user->email,
        'phone'=>$user->phone,
        'name'=>$user->name,
        'id_user'=>$user->id,
        'price'=>$total 
       ]);
       $mailData=[
        'subject'=>'Thông tin đơn hàng của bạn',
        'name'=>$user->name,
        'email'=>$user->email,
        'cart'=>$cart,
        'total'=>$total
       ];
       Mail::to($user->email)->send(new Notify($mailData));
       session()->forget('cart');
       return redirect()->back()->with('success','Đặt hàng thành công');
    }
    public function quickRegister(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'phone'=>'required|string',
            'password'=>'required|string|min:6'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'passwod'=>bcrypt($request->password)
        ]);
        Auth::login($user);
        return redirect()->route('order.place');
    }
}
