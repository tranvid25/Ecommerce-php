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
                    <h2 class="title text-center">Thêm sản phẩm</h2>
                    <div class="signup-form">
                        <h2>Thông tin sản phẩm</h2>
                        <form action="{{ route('frontend.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="name" placeholder="Tên sản phẩm" required>
                            <input type="number" name="price" placeholder="Giá" required>
                            <input type="text" name="company" placeholder="Công ty sản xuất" required>

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
                            <input type="number" name="sale" id="salePrice" placeholder="Giá sale" style="display: none;">

                            <!-- Mô tả sản phẩm -->
                            <textarea name="detail" placeholder="Chi tiết sản phẩm" rows="4" required></textarea>

                            <!-- Upload hình ảnh -->
                            <input type="file" name="images[]" multiple accept="image/*" required>

                            <button type="submit" class="btn btn-default">Thêm sản phẩm</button>
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
