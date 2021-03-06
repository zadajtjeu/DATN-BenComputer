<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\RatingController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', [HomeController::class, 'index'])->name('home');

// Page
Route::get('about', function () {
    return view('pages.about');
})->name('about');

Route::get('contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('rule', function () {
    return view('pages.rule');
})->name('rule');

Route::get('language/{language}', [HomeController::class, 'changeLanguage'])->name('language');

Route::get('search', [ProductController::class, 'search'])->name('search');

Route::get('searchajax', [ProductController::class, 'searchAjax'])->name('search.ajax');

Route::get('products/{slug}.p{id}.html', [ProductController::class, 'getDetails'])
    ->where(['id' => '[0-9]+'])
    ->name('products.details');

// Post
Route::get('news', [PostController::class, 'index'])
    ->name('posts.news');

Route::get('news/{slug}.html', [PostController::class, 'viewPost'])
    ->name('posts.details');

Route::get('news/{slug}/', [PostController::class, 'ViewPostType'])
    ->name('posts.type');

Route::get('brands/{slug}', [ProductController::class, 'brandDetails'])
    ->name('brands.details');

Route::get('categories/{slug}', [ProductController::class, 'categoryDetails'])
    ->name('categories.details');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminAccess']], function () {
    Route::get('/', [Admin\AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('products', Admin\ProductController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
    Route::delete('products/edit/{product_id}/deleteImage/{image_id}',
        [Admin\ProductController::class, 'deleteImage']
    )->name('admin.products.deleteImage');

    Route::get('orders', [Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/new', [Admin\OrderController::class, 'getNewOrders'])->name('admin.orders.new');
    Route::get('orders/process', [Admin\OrderController::class, 'getProcessOrder'])->name('admin.orders.process');
    Route::get('orders/shipping', [Admin\OrderController::class, 'getShippingOrder'])->name('admin.orders.shipping');
    Route::get('orders/details/{id}', [Admin\OrderController::class, 'getDetails'])
        ->name('admin.orders.details');
    Route::delete('orders/details/{id}', [Admin\OrderController::class, 'cancel'])->name('admin.orders.cancel');
    Route::post('orders/details/cod/{id}', [Admin\OrderController::class, 'switchCOD'])->name('admin.orders.cod');
    Route::patch('orders/details/{id}', [Admin\OrderController::class, 'update'])->name('admin.orders.update');
    Route::get('orders/print/{id}', [Admin\OrderController::class, 'print'])
        ->name('admin.orders.print');

    //User management manager
    Route::get('users/list', [Admin\UserController::class, 'listUser'])
        ->name('admin.users.list');
    Route::patch('users/{id}/block', [Admin\UserController::class, 'blockUser'])
        ->name('admin.users.block');
    Route::patch('users/{id}/unblock', [Admin\UserController::class, 'unblockUser'])
        ->name('admin.users.unblock');

    // Post management
    Route::resource('posts', Admin\PostController::class)
    ->except(['show'])
    ->names([
        'index' => 'admin.posts.index',
        'create' => 'admin.posts.create',
        'store' => 'admin.posts.store',
        'edit' => 'admin.posts.edit',
        'update' => 'admin.posts.update',
        'destroy' => 'admin.posts.destroy',
    ]);

    Route::post('select-month-order', [Admin\AdminController::class, 'selectMonthOrder'])
        ->name('admin.statistic.selectMonthOrder');
    Route::post('select-year-revenue', [Admin\AdminController::class, 'selectYearRevenue'])
        ->name('admin.statistic.selectYearRevenue');

    // Only for admin
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        //User management
        Route::resource('users', Admin\UserController::class)
            ->except(['show', 'create', 'store'])
            ->names([
                'index' => 'admin.users.index',
                'edit' => 'admin.users.edit',
                'update' => 'admin.users.update',
                'destroy' => 'admin.users.destroy',
            ]);
        Route::patch('users/{id}/password', [Admin\UserController::class, 'resetPassword'])
            ->name('admin.users.password');
        Route::patch('users/{id}/role', [Admin\UserController::class, 'editRole'])
            ->name('admin.users.role');

        Route::resource('categories', Admin\CategoryController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.categories.index',
                'create' => 'admin.categories.create',
                'store' => 'admin.categories.store',
                'edit' => 'admin.categories.edit',
                'update' => 'admin.categories.update',
                'destroy' => 'admin.categories.destroy',
            ]);
        Route::resource('brands', Admin\BrandController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.brands.index',
                'create' => 'admin.brands.create',
                'store' => 'admin.brands.store',
                'edit' => 'admin.brands.edit',
                'update' => 'admin.brands.update',
                'destroy' => 'admin.brands.destroy',
            ]);
        Route::resource('posttypes', Admin\PostTypeController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.posttypes.index',
                'create' => 'admin.posttypes.create',
                'store' => 'admin.posttypes.store',
                'edit' => 'admin.posttypes.edit',
                'update' => 'admin.posttypes.update',
                'destroy' => 'admin.posttypes.destroy',
            ]);
        Route::resource('vouchers', Admin\VoucherController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.vouchers.index',
                'create' => 'admin.vouchers.create',
                'store' => 'admin.vouchers.store',
                'edit' => 'admin.vouchers.edit',
                'update' => 'admin.vouchers.update',
                'destroy' => 'admin.vouchers.destroy',
            ]);
        Route::patch('vouchers/block/{id}', [Admin\VoucherController::class, 'block'])->name('admin.vouchers.block');
        Route::patch('vouchers/unblock/{id}', [Admin\VoucherController::class, 'unblock'])->name('admin.vouchers.unblock');
    });
});

// User function
Route::group(['middleware' => ['auth']], function () {
    // Cart
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('cart/minus/{product_id}', [CartController::class, 'minus'])->name('cart.minus');
    Route::get('cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('cart/voucher', [CartController::class, 'voucherApply'])->name('cart.voucher');
    Route::delete('cart/voucher/delete', [CartController::class, 'voucherDetele'])->name('cart.voucher.delete');
    //Checkout
    Route::post('cart/checkout', [CartController::class, 'checkoutMethod'])->name('cart.checkout');
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.form');
    Route::post('checkout', [CheckoutController::class, 'addOrder'])->name('checkout.form');
    Route::get('checkout/online', [CheckoutController::class, 'vnpayReturn'])->name('checkout.vnpayReturn');
    Route::get('checkout/json/provinces', [CheckoutController::class, 'getProvinces'])->name('checkout.provinces');
    Route::get('checkout/json/districts/{id}', [CheckoutController::class, 'getDistricts'])->name('checkout.districts');
    Route::get('checkout/json/wards/{id}', [CheckoutController::class, 'getWards'])->name('checkout.wards');

    // User
    Route::get('user/orderhistory', [OrderController::class, 'index'])->name('user.orderhistory');
    Route::get('user/orderdetails/{id}', [OrderController::class, 'getDetails'])->name('user.orderdetails');
    Route::delete('user/ordercancel/{id}', [OrderController::class, 'cancel'])->name('user.ordercancel');
    Route::post('user/orderrepay/{id}', [OrderController::class, 'repayment'])->name('user.orderrepay');
    Route::post('user/ordercod/{id}', [OrderController::class, 'switchCOD'])->name('user.ordercod');

    // rating
    Route::get('user/rate/{id}', [RatingController::class, 'index'])->name('user.rate');
    Route::post('user/rate/{id}/create', [RatingController::class, 'create'])->name('user.rate.create');

    // Profile
    Route::get('user', [ProfileController::class, 'editProfile'])->name('profile');
    Route::patch('user', [ProfileController::class, 'updateProfile'])->name('user.update');
    Route::get('user/change-password', [ProfileController::class, 'editPassword'])->name('user.password.edit');
    Route::put('user/change-password', [ProfileController::class, 'updatePassword'])
        ->name('user.password.update');
});
