<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProductController;

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

Auth::routes();

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('language/{language}', [HomeController::class, 'changeLanguage'])->name('language');

Route::get('products/{slug}.p{id}.html', [ProductController::class, 'getDetails'])
    ->where(['id' => '[0-9]+'])
    ->name('products.details');
