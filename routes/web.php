<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

Route::get('', [HomeController::class, 'index'])->name('home');

Route::get('/admin/categories', [CategoryController::class, 'index'])
    ->name('admin.categories.index');

Route::get('/admin/categories/create', [CategoryController::class, 'create'])
    ->name('admin.categories.create');

Route::post('/admin/categories', [CategoryController::class, 'store'])
    ->name('admin.categories.store');

Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'edit'])
    ->name('admin.categories.edit');

Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])
    ->name('admin.categories.update');

Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])
    ->name('admin.categories.destroy');
