@extends('frontend.layout.master')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Image</td>
                        <td class="description">Name</td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($cart))
                        @foreach($cart as $item)
                        <tr data-id="{{$item['Id']}}">
                            <td class="cart_product">
                                @php
                                    $images = json_decode($item['hinhanh'], true);
                                    $firstImage = $images[0] ?? 'default.png';
                                @endphp
                                <a href="#"><img src="{{ asset('upload/product/' . $firstImage) }}" width="80"></a>
                            </td>
                            <td class="cart_description">
                                <h4>{{ $item['name'] }}</h4>
                                <p>ID: {{ $item['Id'] }}</p>
                            </td>
                            <td class="cart_price">
                                <p>{{ number_format($item['price']) }}₫</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <a class="cart_quantity_up" data-id="{{$item['Id']}}"> + </a>
                                    <input class="cart_quantity_input" type="text" name="quantity" value="{{ $item['quantity'] }}" autocomplete="off" size="2">
                                    <a class="cart_quantity_down" data-id="{{$item['Id']}}"> - </a>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    {{ number_format($item['price'] * $item['quantity']) }}₫
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" data-id="{{$item['Id']}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr><td colspan="6">Giỏ hàng trống</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="total_area text-end mt-4">
            <h4>Tổng tiền:
                <span id="cart-total">{{number_format($total)}}đ</span>
            </h4>
        </div>
        <script>
            function updateCart(id,action){
                $.ajax({
                    url:"{{route('cart.update')}}",
                    method:'POST',
                    data:{
                        _token:"{{csrf_token()}}",
                        id:id,
                        action:action
                    },
                    success:function(res){
                        $('tr[data-id="' + id + '"] .cart_quantity_input').val(res.new_quantity);
                        $('tr[data-id="' + id + '"] .cart_total_price').text(res.new_total.toLocaleString() + '₫');
                        $('#cart-total').text(res.cart_total.toLocaleString() + '₫');
                    },
                    error:function(){
                        alert("Lỗi cập nhật giỏ hàng");
                    }
                })
            }
            $(document).ready(function(){
                $('.cart_quantity_up').click(function(){
                    let id=$(this).data('id');
                    updateCart(id,'tang');
                })
                $('.cart_quantity_down').click(function(){
                    let id=$(this).data('id');
                    updateCart(id,'giam');
                })
            });
            $('.cart_quantity_delete').click(function(e){
    e.preventDefault();
    let id = $(this).data('id');

    if(confirm('Bạn có chắc muốn xóa sản phẩm này không?')) {
        $.ajax({
            url: "{{ route('cart.delete') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(res){
                $('tr[data-id="' + id + '"]').remove();
                $('#cart-total').text(res.cart_total.toLocaleString() + '₫');

                // Nếu giỏ hàng trống
                if ($('.cart_info tbody tr').length == 0) {
                    $('.cart_info tbody').html('<tr><td colspan="6">Giỏ hàng trống</td></tr>');
                }
            },
            error: function(){
                alert("Xóa sản phẩm thất bại");
            }
        });
    }
});

        </script>
    </div>
</section>
 <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <input type="checkbox">
                            <label>Use Coupon Code</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Use Gift Voucher</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Estimate Shipping & Taxes</label>
                        </li>
                    </ul>
                    <ul class="user_info">
                        <li class="single_field">
                            <label>Country:</label>
                            <select>
                                <option>United States</option>
                                <option>Bangladesh</option>
                                <option>UK</option>
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>Ucrane</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                            
                        </li>
                        <li class="single_field">
                            <label>Region / State:</label>
                            <select>
                                <option>Select</option>
                                <option>Dhaka</option>
                                <option>London</option>
                                <option>Dillih</option>
                                <option>Lahore</option>
                                <option>Alaska</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                        
                        </li>
                        <li class="single_field zip-field">
                            <label>Zip Code:</label>
                            <input type="text">
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Cart Sub Total <span>$59</span></li>
                        <li>Eco Tax <span>$2</span></li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total <span>$61</span></li>
                    </ul>
                        <a class="btn btn-default update" href="">Update</a>
                        <a class="btn btn-default check_out" href="">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection