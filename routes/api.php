<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Client\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api'])->group(function ()  {
    Route::get('/getProduct', [ProductController::class, 'index']);

    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

});
