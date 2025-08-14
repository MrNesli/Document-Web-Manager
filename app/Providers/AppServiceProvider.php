<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
        //
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

        /* Builder::macro('itemExists', function (int $id) { */
        /*     return $this->where('id', $id)->exists(); */
        /* }); */
    }
}
