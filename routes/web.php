<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UploadFileController;
use Illuminate\Support\Facades\Route;

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
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'getLoginPage')->name('getLogin');
    Route::post('/login', 'doLogin')->name('doLogin');
    Route::post('/logout', 'doLogout')->name('doLogout');

});
Route::middleware(['auth.admin'])->group(function () {
    //Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.index');
    });

    Route::resource('products', ProductController::class);
    Route::post('getListProduct', [ProductController::class, 'getListProduct'])->name('products.getListProduct');

    Route::resource('uploadFiles', UploadFileController::class);

    Route::resource('categories', CategoryController::class);
    Route::post('getListCategory', [CategoryController::class, 'getListCategory'])->name('category.getListCategory');


});
