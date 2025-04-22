@extends('frontend.layout.master')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Account</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a href="#">account</a></h4>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a href="#">My product</a></h4>
                            </div>
                        </div>
                        
                    </div><!--/category-products-->
                
                    
                </div>
            </div>
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Update user</h2>
                     <div class="signup-form"><!--sign up form-->
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
                    @endif
                    <form method="POST" action="{{ route('user.account.update', Auth::id()) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" placeholder="Name">
                        <input type="email" value="{{ Auth::user()->email }}" class="form-control" disabled>
                        <!-- Thêm hidden field cho email nếu cần thiết -->
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <input type="text" name="address" value="{{ Auth::user()->address }}" class="form-control" placeholder="Address">
                        <select name="country_id" class="form-control">
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ Auth::user()->country_id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="phone" value="{{ Auth::user()->phone }}" class="form-control" placeholder="Phone">
                        <input type="file" name="avatar" class="form-control">
                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<style>
    .signup-form input, .signup-form select {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #e6e6e6;
    background: #f0f0f0;
    width: 100%;
}

.signup-form input[type="password"] {
    background: #e8f0fe;
}

.signup-form button {
    background: #FE8C00;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 10px;
}
</style>