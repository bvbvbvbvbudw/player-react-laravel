<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get("/", [PageController::class, "index"])->name("home");

Route::get("/dashboard", [PageController::class, "dashboard"])->name("dashboard");

Route::get('/my-tracks', [TrackController::class, 'myTracks'])->name('tracks.my');
Route::get('/tracks/upload', [TrackController::class, 'create'])->name('tracks.upload');
Route::post('/tracks/upload', [TrackController::class, 'store']);

Route::get('/my-playlists', [PlaylistController::class, 'index'])->name('playlists.my');
Route::get('/my-playlists/{id}', [PlaylistController::class, 'show'])->name('playlists.my.show');
Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
Route::post('/playlists/{playlist}/add-track', [PlaylistController::class, 'addTrack'])->name('playlists.addTrack');

Route::post('/tracks/{track}/toggle-like', [TrackController::class, 'toggleLike']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
