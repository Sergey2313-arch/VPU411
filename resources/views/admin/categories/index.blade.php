<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Категории</title>
</head>
<body>

<h1>Категории</h1>

@if($categories->isEmpty())
    <p>Категорий пока нет.</p>
@else

    @foreach($categories as $category)

        <div style="margin-bottom: 10px;">

            <strong>
                {{ $category->title }}
            </strong>

            <a href="{{ route('admin.categories.edit', $category->id) }}">
                Редактировать
            </a>

            <form
                action="{{ route('admin.categories.destroy', $category->id) }}"
                method="POST"
                style="display: inline;"
            >

                @csrf
                @method('DELETE')

                <button type="submit">
                    Удалить
                </button>

            </form>

        </div>

    @endforeach

@endif

</body>
</html>
