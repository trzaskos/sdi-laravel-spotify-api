<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('auth')->group(function () {
    // Register new user
    Route::post('/register', [AuthController::class, 'register']);

    // Login and receive token
    Route::post('/login', [AuthController::class, 'login']);

    // Logout (protected)
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});
