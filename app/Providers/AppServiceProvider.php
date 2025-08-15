<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // We register a binding for the File Facade's class
        app()->bind('document', function () {
            return new \App\Utils\Document();
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
    }
}
