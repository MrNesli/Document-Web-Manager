<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'categoriesView'])->name('categories');

Route::get('/categories/new', [CategoryController::class, 'createView']);
Route::post('/categories/new', [CategoryController::class, 'create'])->name('categories.new');
Route::get('/categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

Route::get('/categories/{id}', [CategoryController::class, 'categoryView'])->name('category');
