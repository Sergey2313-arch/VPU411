<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'password' => $userId
                ? [
                    'nullable',
                    'string',
                    'min:6',
                    Rule::excludeIf(fn () => blank($this->password)),
                ]
                : [
                    'required',
                    'string',
                    'min:6',

            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя пользователя.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Пользователь с таким email уже существует.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
        ];
    }
}
