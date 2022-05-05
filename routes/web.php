<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController;
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

Route::get('language/{language}', [HomeController::class, 'changeLanguage'])->name('language');

Route::get('products/{slug}.p{id}.html', [ProductController::class, 'getDetails'])
    ->where(['id' => '[0-9]+'])
    ->name('products.details');

Route::get('brands/{slug}.html', [ProductController::class, 'brandDetails'])
    ->name('brands.details');

Route::get('categories/{slug}.html', [ProductController::class, 'categoryDetails'])
    ->name('categories.details');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminAccess']], function () {
    Route::get('/', [Admin\AdminController::class, 'index'])->name('admin.dashboard');
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
/*    Route::resource('products', Admin\ProductController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
    Route::resource('users', Admin\UserController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    Route::patch('user/{id}/block', [Admin\UserController::class, 'blockUser'])
        ->name('admin.users.block');
    Route::patch('user/{id}/unblock', [Admin\UserController::class, 'unblockUser'])
        ->name('admin.users.unblock');*/
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
    Route::get('user', [ProfileController::class, 'profile'])->name('profile');
    Route::get('user/orderhistory', [OrderController::class, 'index'])->name('user.orderhistory');
    Route::get('user/orderdetails/{id}', [OrderController::class, 'getDetails'])->name('user.orderdetails');
    Route::delete('user/ordercancel/{id}', [OrderController::class, 'cancel'])->name('user.ordercancel');
    Route::post('user/orderrepay/{id}', [OrderController::class, 'repayment'])->name('user.orderrepay');
    Route::post('user/ordercod/{id}', [OrderController::class, 'switchCOD'])->name('user.ordercod');
/*
    // Profile
    Route::get('profile', [ProfileController::class, 'editProfile'])->name('profile');
    Route::patch('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('profile/change-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');

    // User
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/purchase', [UserController::class, 'purchase'])->name('user.purchase');
    Route::get('user/order/{id}', [UserController::class, 'orderDetail'])->name('user.purchase.details');
    Route::post('user/order/{id}/cancel', [UserController::class, 'orderCancel'])->name('user.purchase.cancel');
    //Rating
    Route::get('user/rating', [RatingController::class, 'index'])->name('user.rating');
    Route::get('user/rating/{order_id}', [RatingController::class, 'showAllOrder'])->name('user.rating.view');
    Route::post('user/rating/{order_items_id}', [RatingController::class, 'addRating'])->name('user.rating.send');
    */
});
