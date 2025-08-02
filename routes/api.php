<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;

Route::post('register', [RegistrationController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);

Route::group([
    "middleware" => 'auth:sanctum'
], function () {
    Route::get("user", [AuthController::class, "show"]);
    Route::delete("logout", [AuthController::class, "destroy"]);
    // Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'store']);
});

Route::group([
    "middleware" => 'guest'
], function () {
    Route::post("reset-password", [NewPasswordController::class, "store"])->name('password.reset');;
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::prefix('products/{slug}/reviews')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/{review}', [ReviewController::class, 'show']);

    Route::group([
        "middleware" => 'auth:sanctum'
    ], function () {
        Route::post('/', [ReviewController::class, 'store']);
        Route::patch('/{review}', [ReviewController::class, 'update']);
        Route::delete('/{review}', [ReviewController::class, 'destroy']);
    });
});
