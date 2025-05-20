<?php

use App\Http\Controllers\Api\MusicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'throttle:60,1'])->prefix('music')->group(function () {
    Route::get('/artists', [MusicController::class, 'searchArtists']);
    Route::get('/playlists/{id}', [MusicController::class, 'getPlaylist']);
    Route::get('/tracks', [MusicController::class, 'searchTracks']);
    Route::get('/tracks/{id}', [MusicController::class, 'getTrack']);
    Route::get('/artists/{id}/albums', [MusicController::class, 'getAlbumsByArtist']);
    Route::get('/artists/{id}/top-tracks', [MusicController::class, 'getTopTracksByArtist']);
});
