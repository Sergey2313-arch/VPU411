<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view('auth.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)
            ],

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
        ]);

        // Обновляем имя и email
        $user->name = $request->name;
        $user->email = $request->email;

        // Если пользователь выбрал новую аватарку
        if ($request->hasFile('avatar')) {

            // Удаляем предыдущую аватарку
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Сохраняем новую
            $path = $request->file('avatar')
                ->store('avatars', 'public');

            $user->avatar = $path;
        }

        $user->save();

        return redirect()
            ->route('profile')
            ->with('status', 'profile-updated');
    }

    public function deleteAvatar()
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);

            $user->avatar = null;
            $user->save();
        }

        return redirect()
            ->route('profile')
            ->with('status', 'avatar-deleted');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = auth()->user();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
            ->route('profile')
            ->with('status', 'password-updated');
    }
}
