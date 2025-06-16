<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Country;
use App\Models\Admin\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\ReChaptcha;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function login(){
        return view('frontend.member.login');
    }
    public function register(){
        return view('frontend.member.register');
    }
    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required',
        ]);

        // Verify reCAPTCHA response
        $captchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ])->json();

        // Check if reCAPTCHA is valid
        if (!$captchaResponse['success']) {
            return back()->withErrors(['captcha' => 'Captcha thất bại. Vui lòng thử lại.'])->withInput();
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 0,
        ]);

        return redirect()->with('success', 'Đăng ký thành công! Hãy đăng nhập');
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
        $minPrice = Product::min('price') ?? 0; // Giá thấp nhất
        $maxPrice = Product::max('price') ?? 5000;
        $categories = Category::all();
        $brands = Brand::all();
        $products=Product::all();
        return view('frontend.index.index',compact('products','categories','brands','minPrice','maxPrice'));
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
