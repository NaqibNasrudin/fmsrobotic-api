<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function () {
    echo 'api success';
});
Route::group(['middleware' => 'cors'], function () {
    Route::prefix('/v1')->group(function() {
        Route::prefix('/user')->group(function() {
            Route::post('register', [UserController::class, 'register']);
            Route::post('login', [UserController::class, 'login']);
        });

        Route::prefix('/product')->group(function() {
            Route::post('/add-product', [ProductController::class, 'addProduct']);
            Route::get('/all-product', [ProductController::class, 'getAllProduct']);
            Route::get('/search', [ProductController::class, 'searchProduct']);
        });

    });
});
