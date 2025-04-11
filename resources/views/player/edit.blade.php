<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa cầu thủ</title>
</head>
<body>
    <h1>Sửa cầu thủ</h1>
    @if ($errors->any()) 
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('player.update', $player->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Tên Cầu thủ:</label>
        <input type="text" name="name" value="{{ $player->name }}" required><br>

        <label>Tuổi:</label>
        <input type="number" name="age" value="{{ $player->age }}" required><br>

        <label>Quốc Tịch:</label>
        <input type="text" name="nation" value="{{ $player->nation }}" required><br>

        <label>Vị Trí:</label>
        <input type="text" name="position" value="{{ $player->position }}" required><br>

        <label>Lương:</label>
        <input type="number" name="salary" value="{{ $player->salary }}" required><br>

        <button type="submit">Cập nhật</button>
    </form>
    <a href="{{ route('player.index') }}">Quay lại danh sách</a>
</body>
</html>
