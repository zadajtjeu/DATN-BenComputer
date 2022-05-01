<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Image\ImageRepository;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Province\ProvinceRepository;
use App\Repositories\Province\ProvinceRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepository;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\PostType\PostTypeRepository;
use App\Repositories\PostType\PostTypeRepositoryInterface;
use App\Repositories\Rating\RatingRepository;
use App\Repositories\Rating\RatingRepositoryInterface;
use App\Repositories\Voucher\VoucherRepository;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\District\DistrictRepository;
use App\Repositories\District\DistrictRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Shipping\ShippingRepository;
use App\Repositories\Shipping\ShippingRepositoryInterface;
use App\Repositories\Ward\WardRepository;
use App\Repositories\Ward\WardRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );
        $this->app->singleton(
            ImageRepositoryInterface::class,
            ImageRepository::class
        );
        $this->app->singleton(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        $this->app->singleton(
            ProvinceRepositoryInterface::class,
            ProvinceRepository::class
        );
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->singleton(
            OrderItemRepositoryInterface::class,
            OrderItemRepository::class
        );
        $this->app->singleton(
            PostTypeRepositoryInterface::class,
            PostTypeRepository::class
        );
        $this->app->singleton(
            RatingRepositoryInterface::class,
            RatingRepository::class
        );
        $this->app->singleton(
            VoucherRepositoryInterface::class,
            VoucherRepository::class
        );
        $this->app->singleton(
            DistrictRepositoryInterface::class,
            DistrictRepository::class
        );
        $this->app->singleton(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->singleton(
            ShippingRepositoryInterface::class,
            ShippingRepository::class
        );
        $this->app->singleton(
            WardRepositoryInterface::class,
            WardRepository::class
        );
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
