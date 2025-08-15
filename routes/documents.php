
<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/documents/options', [DocumentController::class, 'selectionOptionsView'])->name('documents.options');

Route::post('/documents/options/apply', [DocumentController::class, 'applyOptionsToSelection'])->name('documents.options.apply');

Route::get('/documents/download-zip', [DocumentController::class, 'downloadZip'])->name('documents.download-zip');
Route::post('/documents/new', [DocumentController::class, 'createView'])->name('documents.new');
Route::post('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('/documents/modify/{id}', [DocumentController::class, 'modify'])->name('documents.modify');
Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
Route::get('/documents/delete/{id}', [DocumentController::class, 'delete'])->name('documents.delete');
Route::get('/documents/{id}', [DocumentController::class, 'documentView'])->name('document');
