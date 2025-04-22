@extends('frontend.layout.master')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Tài khoản</h2>
                    <div class="panel-group category-products">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="">Account</a>
                                </h4>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="{{route('frontend.product.my-product')}}">My Product</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td>ID</td>
                                <td class="image">Image</td>
                                <td class="description">Name</td>
                                <td class="price">Price</td>
                                <td class="total">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product )
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td class="cart_product">
                                        @php
                                            $images=json_decode($product->hinhanh);
                                            $firstImage=$images[0] ?? null;
                                        @endphp
                                        @if ($firstImage)
                                            <a href="{{route('frontend.product.detail',$product->id)}}">
                                                <img src="{{asset('upload/product/hinh50_' .$firstImage)}}" alt="" width="85" height="84">
                                            </a>
                                        @endif
                                    </td >
                                    <td class="cart_description"><h4>{{$product->name}}</h4></td>
                                    <td class="cart_price">
                                        <p>${{number_format($product->price)}}</p>
                                    </td>
                                    <td class="cart_total">
                                        <a href="{{ route('frontend.product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{route('frontend.product.detail',$product->id)}}"class="btn btn-sm btn-warning">Detail</a>
                                        <form action="{{ route('frontend.product.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn xóa?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-end mb-3">
                        <a href="{{ route('frontend.product.create') }}" class="btn btn-warning" style="background-color: #f89406; color: white; padding: 8px 20px; border-radius: 3px;">
                            Add New
                        </a>
                    </div>
                              
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection