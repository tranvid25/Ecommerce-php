@extends('frontend.layout.master')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <!-- Sidebar trái -->
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Account</h2>
                    <div class="panel-group category-products" id="accordian">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a href="#">Account</a></h4>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a href="#">My Product</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nội dung form -->
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Cập nhật sản phẩm</h2>
                    <div class="signup-form">
                        <h2>Thông tin sản phẩm</h2>
                        <form action="{{ route('frontend.product.update',$products->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            @method('PUT')
                            <input type="text" name="name" value="{{$products->name}}">
                            <input type="number" name="price" value="{{$products->price}}">
                            <input type="text" name="company" value="{{$products->company}}">

                            <!-- Danh mục -->
                            <select name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <!-- Thương hiệu -->
                            <select name="brand_id" required>
                                <option value="">-- Chọn thương hiệu --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>

                            <!-- Trạng thái: New/Sale -->
                            <select name="status" id="statusSelect" required onchange="toggleSaleInput()">
                                <option value="0">New</option>
                                <option value="1">Sale</option>
                            </select>

                            <!-- Giá sale (ẩn/hiện theo chọn trạng thái) -->
                            <input type="number" name="sale" id="salePrice" value="{{$products->sale}}" style="display: none;">

                            <!-- Mô tả sản phẩm -->
                            <textarea name="detail" rows="4">{{$products->detail}}</textarea>

                            <h4>Ảnh cũ:</h4>
                            @php
                                $images=json_decode($products->hinhanh,true);
                            @endphp
                            <div style="display:flex; gap:10px;">
                            @foreach ($images as $img)
                                <div style="text-align: center;">
                                    <img src="{{asset('upload/product/' .$img)}}" alt="" style="width:50px;height:auto;object-fit:cover;">
                                    <input type="checkbox" name="hinhanhxoa[]" value="{{ $img }}"> Xoá
                                </div>
                            @endforeach
                            </div>
                            <br><label>Thêm hình ảnh mới (tối đa 3 ảnh):</label><br>
                            <input type="file" name="hinhanhmoi[]" multiple accept="image/*"><br><br>
                            <button type="submit" class="btn btn-default">Cập nhật sản phẩm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script xử lý hiển thị ô giá sale -->
    <script>
        function toggleSaleInput() {
            const status = document.getElementById('statusSelect').value;
            const saleInput = document.getElementById('salePrice');
            saleInput.style.display = status == 1 ? 'block' : 'none';
        }
    </script>
</section>
@endsection