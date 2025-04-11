<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Danh sách cầu thủ</h1>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <a href="{{route('player.create')}}">Thêm cầu thủ</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Tên Cầu thủ</th>
            <th>Tuổi</th>
            <th>Quốc Tịch</th>
            <th>Vị Trí</th>
            <th>Lương</th>
        </tr>
        @foreach ($players as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->age}}</td>
            <td>{{$item->nation}}</td>
            <td>{{$item->position}}</td>
            <td>{{$item->salary}}</td>
            <td>
                <a href="{{ route('player.edit', $item->id) }}">Sửa</a> 
                <form action="{{ route('player.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                </form>
            </td>
        </tr>  
        @endforeach
    </table>
</body>
</html>