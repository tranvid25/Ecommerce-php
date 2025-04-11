<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm cầu thủ</title>
</head>
<body>
    <h1>Thêm cầu thủ mới</h1>

    @if ($errors->any()) 
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('player.store') }}" method="POST">
        @csrf
        <label for="name">Tên cầu thủ:</label>
        <input type="text" name="name" required><br>

        <label for="age">Tuổi:</label>
        <input type="number" name="age" required><br>

        <label for="nation">Quốc tịch:</label>
        <input type="text" name="nation" required><br>

        <label for="position">Vị trí:</label>
        <input type="text" name="position" required><br>

        <label for="salary">Lương:</label>
        <input type="number" name="salary" required><br>

        <button type="submit">Thêm cầu thủ</button>
    </form>

    <a href="{{ route('player.index') }}">Quay lại danh sách</a>
</body>
</html>
