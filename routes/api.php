<?php

use App\Http\Controllers\Api\MusicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('music')->group(function () {
    Route::get('/artists', [MusicController::class, 'searchArtists']);
    Route::get('/playlists/{id}', [MusicController::class, 'getPlaylist']);
});
