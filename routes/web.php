<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProductController;
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
        ->name('admin.users.unblock');
    Route::get('order-manager', [Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('order-manager/view-order/{id}', [Admin\OrderController::class, 'viewOrder'])
        ->name('admin.orders.viewOrder');
    Route::post('order-manager/view-order/{id}', [Admin\OrderController::class, 'update'])
        ->name('admin.orders.update');*/
});
