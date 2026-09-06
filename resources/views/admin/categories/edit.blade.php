<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование категории</title>
</head>
<body>

<h1>Редактировать категорию</h1>

<form action="{{ route('admin.categories.update', $category->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div>
        <label>Название:</label>

        <input
            type="text"
            name="title"
            value="{{ $category->title }}"
            required
        >
    </div>

    <br>

    <div>
        <label>Slug:</label>

        <input
            type="text"
            name="slug"
            value="{{ $category->slug }}"
            required
        >
    </div>

    <br>

    <div>
        <label>Родительская категория:</label>

        <select name="parent_id">

            <option value="">Нет</option>

            @foreach($categories as $parent)
                <option
                    value="{{ $parent->id }}"
                    @selected($category->parent_id == $parent->id)
                >
                    {{ $parent->title }}
                </option>
            @endforeach

        </select>
    </div>

    <br>

    <input type="hidden" name="active" value="0">

    <label>
        <input
            type="checkbox"
            name="active"
            value="1"
            @checked($category->active)
        >
        Активна
    </label>

    <br><br>

    <button type="submit">
        Сохранить изменения
    </button>

</form>

</body>
</html>
