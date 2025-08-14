<?php

use App\Http\Controllers\DynamicComponentsController;

Route::get('/components/selection', [DynamicComponentsController::class, 'selectionComponent']);
Route::get('/components/category-select', [DynamicComponentsController::class, 'categorySelectComponent']);
Route::get('/components/uploaded-document-collapsible', [DynamicComponentsController::class, 'uploadedDocumentCollapsibleComponent']);

?>
