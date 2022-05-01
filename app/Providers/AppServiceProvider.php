<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        //lang
        view()->composer('*', function ($view) {

            $menu_categories = Category::whereNull('parent_id')
                ->with('children')->get();

            $view->with([
                'menu_categories'=>$menu_categories,
            ]);
        });
    }
}
