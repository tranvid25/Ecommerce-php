<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Thông tin đơn hàng</h2>
<p>Họ tên: {{ $mailData['name'] }}</p>
<p>Email: {{ $mailData['email'] }}</p>
<p>Tổng tiền: ${{ number_format($mailData['total'], 2) }}</p>

<h4>Sản phẩm:</h4>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mailData['cart'] as $item)
        <tr>
            <td>
                @php
                    $images = json_decode($item['hinhanh'], true);
                    $firstImage = $images[0] ?? 'default.png';
                    $imageUrl = asset('upload/product/' . $firstImage);
                @endphp
                <img src="{{ $imageUrl }}" width="100px" height="100px" alt="Hình sản phẩm">
            </td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>${{ number_format($item['price'], 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>