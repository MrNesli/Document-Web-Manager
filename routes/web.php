<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'categoriesView'])->name('categories');

Route::get('/categories/new', [CategoryController::class, 'createView']);
Route::post('/categories/new', [CategoryController::class, 'create'])->name('categories.new');

Route::get('/categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
Route::get('/categories/{id}', [CategoryController::class, 'categoryView'])->name('category');

Route::get('/documents/options', [DocumentController::class, 'selectionOptions'])->name('documents.options');
Route::post('/documents/options/apply', [DocumentController::class, 'applyOptionsToSelection'])->name('documents.options.apply');

Route::get('/documents/download-zip', [DocumentController::class, 'downloadZip'])->name('documents.download-zip');
Route::post('/documents/new', [DocumentController::class, 'createView'])->name('documents.new');
Route::post('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('/documents/modify/{id}', [DocumentController::class, 'modify'])->name('documents.modify');
Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
Route::get('/documents/delete/{id}', [DocumentController::class, 'delete'])->name('documents.delete');
Route::get('/documents/{id}', [DocumentController::class, 'documentView'])->name('document');

include __DIR__ . '/dynamic-components.php';
