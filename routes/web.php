<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\User\BlogUserController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//PROFILE
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
  
  // Profile
  Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
  Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');

  // Country & Blog
  Route::resources([
    'country' => CountryController::class,
    'blog' => BlogController::class,
    'category' => CategoryController::class,
    'brand' => BrandController::class
]);
  Route::get('/product',[AdminProductController::class,'index'])->name('product.index');
  Route::delete('/product/{id}',[AdminProductController::class,'destroy'])->name('product.destroy');
});

//logout
Route::get('admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
//User
Route::get('/user/index',[UserController::class,'index'])->name('user.index');
//Đăng nhập
Route::get('/login',[UserController::class,'login'])->name('login');
Route::post('/login',[UserController::class,'postLogin'])->name('postLogin');
//Đăng ký
Route::get('/register',[UserController::class,'register'])->name('register');
Route::post('/register',[UserController::class,'postRegister'])->name('postRegister');
//hiển thị BlogUser
Route::get('/user/blog',[BlogUserController::class,'index'])->name('user.blog');
Route::get('/user/blog/{id}',[BlogUserController::class,'show'])->name('user.blog.show');
//RATE
Route::post('/user/rate', [RateController::class, 'store'])->name('blog.rate');
Route::get('/user/get-rating', [RateController::class, 'getRating'])->name('get.rating');
//COMMENT
Route::post('/user/comment',[CommentController::class,'store'])->name('blog.comment');
Route::get('/load-comments/{blog_id}', [CommentController::class, 'loadComments'])->name('load.comments');
//profile user
Route::get('/user/account',[UserController::class,'account'])->name('user.account');
Route::put('/user/update_account/{id}',[UserController::class,'update'])->name('user.account.update');
//product
Route::get('product/index',[ProductController::class,'index'])->name('frontend.product.my-product');
Route::get('product/edit/{id}',[ProductController::class,'edit'])->name('frontend.product.edit');
Route::get('product/detail/{id}',[ProductController::class,'show'])->name('frontend.product.detail');
Route::put('product/update/{id}',[ProductController::class,'update'])->name('frontend.product.update');
// Trang form thêm sản phẩm
Route::get('product/add', [ProductController::class, 'create'])->name('frontend.product.create');
// Xử lý lưu sản phẩm (POST)
Route::post('product/store', [ProductController::class, 'store'])->name('frontend.product.store');
Route::delete('product/delete/{id}',[ProductController::class,'destroy'])->name('frontend.product.destroy');
//add to cart
Route::post('/add/cart')

