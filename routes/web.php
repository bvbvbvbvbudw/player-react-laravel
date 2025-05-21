<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

// ROUTE FOR GUEST
Route::get("/", [PageController::class, "index"])->name("home");
// END ROUTE FOR GUEST


// ROUTE FOR CREATOR/USER
Route::get('/search', [SearchController::class, 'search']);
Route::get('/search-results', [SearchController::class, 'index'])->name('search.results');

Route::get("/dashboard", [PageController::class, "dashboard"])->name("dashboard");
Route::post('/tracks/{track}/toggle-like', [TrackController::class, 'toggleLike']);
Route::post('/playlists/{playlist}/toggle-like', [PlaylistController::class, 'toggleLike']);
Route::post('/tracks/{track}/increment-plays', [TrackController::class, 'incrementPlays']);

//   ROUTE FOR LISTENER
Route::get('/playlist/{id}', [PlaylistController::class, 'show'])->name('playlists.my.show');
//   END ROUTE FOR LISTENER
Route::get('/my-tracks', [TrackController::class, 'myTracks'])->name('tracks.my');
Route::get('/tracks/upload', [TrackController::class, 'create'])->name('tracks.upload');
Route::post('/tracks/upload', [TrackController::class, 'store']);

Route::get('/my-playlists', [PlaylistController::class, 'index'])->name('playlists.my');
Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
Route::post('/playlists/{playlist}/add-track', [PlaylistController::class, 'addTrack'])->name('playlists.addTrack');
// END ROUTE FOR CREATOR/USER

// ROUTES ADMIN
Route::get("/admin", [AdminPageController::class, "index"])->name("admin.index");
Route::get("/admin/genre", [AdminPageController::class, "genre"])->name("admin.genre");
// END ROUTES ADMIN


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
