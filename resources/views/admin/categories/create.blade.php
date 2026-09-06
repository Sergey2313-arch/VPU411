<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание категории</title>
</head>
<body>

<h1>Создать категорию</h1>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <div>
        <label>Название:</label>
        <input type="text" name="title" required>
    </div>

    <br>

    <div>
        <label>Slug:</label>
        <input type="text" name="slug" required>
    </div>

    <br>

    <div>
        <label>Родительская категория:</label>

        <select name="parent_id">
            <option value="">Нет</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <input type="hidden" name="active" value="0">

        <label>
            <input type="checkbox" name="active" value="1" checked>
            Активна
        </label>
    </div>

    <br>

    <button type="submit">Создать</button>
</form>

</body>
</html>
