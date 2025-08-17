<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register a binding for the Document Facade's class
        app()->bind('document', function () {
            return new \App\Utils\Document();
        });

        // Register a binding for the Category Facade's class
        app()->bind('category', function () {
            return new \App\Utils\Category();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Facades\View::composer(['components.document.info.collapsible', 'components.category.select'], function (View $view) {
            $categories = Category::all();
            $view->with('categories', $categories);
        });

        Blade::withoutDoubleEncoding();

        // On document delete remove the file
        Document::deleting(function (Document $document) {
            $document->deleteFile();
        });

        // On category delete remove the preview image
        Category::deleting(function (Category $category) {
            $category->deleteImage();
            $category->deleteDocuments();
        });
    }
}
