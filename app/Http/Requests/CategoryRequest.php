<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        $categoryId = $this->route('id');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                Rule::notIn([$categoryId]),
            ],

            'active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'название',
            'slug' => 'slug',
            'parent_id' => 'родительская категория',
            'active' => 'активность',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Введите название категории.',
            'slug.required' => 'Введите slug категории.',
            'slug.unique' => 'Категория с таким slug уже существует.',
            'parent_id.exists' => 'Выбранная родительская категория не существует.',
            'parent_id.not_in' => 'Категория не может быть родителем самой себе.',
        ];
    }
}
