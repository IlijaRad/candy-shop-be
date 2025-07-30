<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\PasswordResetLinkController;
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
