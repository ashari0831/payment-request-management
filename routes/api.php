<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('role:admin')->group(function () {

        Route::post('/products', [ProductController::class, 'store']);

        Route::apiResource('/carts', CartController::class)->only(['index', 'show']);
    });

    Route::get('/user/cart', [CartController::class, 'showAuthUserCart']);

    Route::post('/carts/products/{product}/attach', [CartController::class, 'attachProduct'])->middleware('ensureProductQuantity');
    Route::post('/carts/{cart}/products/{product}/detach', [CartController::class, 'detachProduct']);

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
