<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Sportswear
                        </a>
                    </h4>
                </div>
                <div id="sportswear" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><a href="#">Nike </a></li>
                            <li><a href="#">Under Armour </a></li>
                            <li><a href="#">Adidas </a></li>
                            <li><a href="#">Puma</a></li>
                            <li><a href="#">ASICS </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#mens">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Mens
                        </a>
                    </h4>
                </div>
                <div id="mens" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><a href="#">Fendi</a></li>
                            <li><a href="#">Guess</a></li>
                            <li><a href="#">Valentino</a></li>
                            <li><a href="#">Dior</a></li>
                            <li><a href="#">Versace</a></li>
                            <li><a href="#">Armani</a></li>
                            <li><a href="#">Prada</a></li>
                            <li><a href="#">Dolce and Gabbana</a></li>
                            <li><a href="#">Chanel</a></li>
                            <li><a href="#">Gucci</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#womens">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Womens
                        </a>
                    </h4>
                </div>
                <div id="womens" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><a href="#">Fendi</a></li>
                            <li><a href="#">Guess</a></li>
                            <li><a href="#">Valentino</a></li>
                            <li><a href="#">Dior</a></li>
                            <li><a href="#">Versace</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#">Kids</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#">Fashion</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#">Households</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#">Interiors</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#">Clothing</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#">Bags</a></h4>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#">Shoes</a></h4>
                </div>
            </div>
        </div><!--/category-products-->
    
        <div class="brands_products"><!--brands_products-->
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#"> <span class="pull-right">(50)</span>Acne</a></li>
                    <li><a href="#"> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                    <li><a href="#"> <span class="pull-right">(27)</span>Albiro</a></li>
                    <li><a href="#"> <span class="pull-right">(32)</span>Ronhill</a></li>
                    <li><a href="#"> <span class="pull-right">(5)</span>Oddmolly</a></li>
                    <li><a href="#"> <span class="pull-right">(9)</span>Boudestijn</a></li>
                    <li><a href="#"> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                </ul>
            </div>
        </div>
        <!--/brands_products-->
        <div class="price-range"><!--price-range-->
            <h2>Price Range</h2>
            <div class="well">
                 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="5000" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                 <b>$ 0</b> <b class="pull-right">$ 5000</b>
            </div>
        </div>
        <script>
        $(document).ready(function() {
    // Khởi tạo Slider cho giá
    var slider = new Slider('#sl2', {
        formatter: function(value) {
            return 'Current value: $' + value[0].toFixed(2) + ' - $' + value[1].toFixed(2);
        },
        tooltip: 'always',
        step: 0.01, // Đặt độ chính xác của thanh giá (0.01 là 2 chữ số thập phân)
        min: 0,
        max: 5000,
        value: [250, 450]
    });

    // Gọi AJAX mỗi khi kéo thanh giá và dừng lại (slideStop)
    slider.on('slideStop', function(value) {
        var minPrice = value[0].toFixed(2);  // Đảm bảo có 2 chữ số thập phân
        var maxPrice = value[1].toFixed(2);  // Đảm bảo có 2 chữ số thập phân
        console.log("Min Price: ", minPrice, "Max Price: ", maxPrice);  // Kiểm tra giá trị slider trong console
        fetchProducts(minPrice, maxPrice);  // Gửi giá trị min và max
    });

    var defaultValues = slider.getValue();
    fetchProducts(defaultValues[0], defaultValues[1]);

    // Hàm AJAX để tải sản phẩm theo giá trị thanh giá
    function fetchProducts(minPrice, maxPrice) {
        $.ajax({
            url: "{{ route('searchProduct.price') }}",
            method: 'GET',
            data: {
                min_price: minPrice,
                max_price: maxPrice
            },
            beforeSend: function() {
                $('#product-list').html('<p class="text-center">Loading...</p>');
            },
            success: function(products) {
                if (products.length > 0) {
                    var html = '';
                    $.each(products, function(index, product) {
                        let images = JSON.parse(product.hinhanh || '[]');
                        let imageUrl = images.length > 0 ? '/upload/product/' + images[0] : '/upload/product/default.png';

                        html += `
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="${imageUrl}" alt="">
                                        <h2 style="text-align:center;margin-top:12px;">$${product.price.toFixed(2)}</h2>
                                        <p>${product.name}</p>
                                        <a href="#" class="btn btn-default add-to-cart" data-id="${product.id}"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });

                    $('#product-list').html(html);
                } else {
                    $('#product-list').html('<div class="col-sm-12"><p class="text-center">No products found in this price range.</p></div>');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#product-list').html('<p class="text-center">Failed to load products.</p>');
            }
        });
    }
});

        </script>
        <!--/price-range-->
        
        <div class="shipping text-center"><!--shipping-->
            <img src="images/home/shipping.jpg" alt="" />
        </div><!--/shipping-->
    
    </div>
</div>