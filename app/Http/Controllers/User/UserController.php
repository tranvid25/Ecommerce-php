<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Admin\Country;
use App\Models\Admin\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(){
        return view('frontend.member.login');
    }
    public function register(){
        return view('frontend.member.register');
    }
    public function postRegister(Request $request){
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'level'=>0,
        ]);
        return redirect()->route('login')->with('success','Đăng ký thành công! Hãy đăng nhập');
    }
    public function postLogin(LoginRequest $request) {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_me'); 
    
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user(); 
            if ($user->level == 1) {
                return redirect()->route('admin.dashboard')->with('success','Đăng nhập thành công! Chào mừng bạn,'.$user->name);
            } else {
                return redirect()->route('user.index');
            }
        }
    
        return redirect()
        ->back()
        ->with('error', 'Email hoặc mật khẩu không đúng.');
    }
    
    
    public function index(){
        $products=Product::all();
        return view('frontend.index.index',compact('products'));
    }
    public function logout(){
        Auth::logout();
        return redirect()->back();
    }
    public function account(){
        $countries=Country::all();
        return view('frontend.member.account',compact('countries'));
    }
    public function update(UpdateProfileRequest $request,string $id){
        $userId=Auth::id();
        $user=User::findOrFail($userId);
        $data=$request->all();
        $file=$request->avatar;
        if(!empty($file)){
            $data['avatar']=$file->getClientOriginalName();
        }
        if($user->update($data)){
            if(!empty($file)){
                $file->move('upload/user/avatar',$file->getClientOriginalName());
            }
            return redirect()->back()->with('success',__('Update profile success.'));
        }
        else{
            return redirect()->back()->withErrors('Update profile error');
        }
    }
}
