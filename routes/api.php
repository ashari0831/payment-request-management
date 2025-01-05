<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::get('/payment-requests', [PaymentRequestController::class, 'index']);

        Route::post('/payment-requests/change-status', [PaymentRequestController::class, 'changeStatus']);

        Route::get('/files/{file}/download', [PaymentRequestController::class, 'downloadAttachment']);

        Route::post('/payment-requests/pay', [PaymentRequestController::class, 'payPaymentRequests']);
    });

    Route::post('/payment-requests', [PaymentRequestController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
