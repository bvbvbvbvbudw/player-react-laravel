<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\GenreController;
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

Route::get("/admin/track", [AdminPageController::class, "track"])->name("admin.track");

Route::get("/admin/playlist", [AdminPageController::class, "playlist"])->name("admin.playlist");

Route::get("/admin/users", [AdminPageController::class, "users"])->name("admin.users");
Route::put('/admin/users/{user}', [AdminPageController::class, 'updateUser'])->name('admin.users.update');
Route::get('/admin/users/{user}/edit', [AdminPageController::class, 'editUser'])->name('admin.users.edit');
Route::delete('admin/users/{user}', [AdminPageController::class, 'destroyUser'])->name('admin.users.destroy');

Route::get("/admin/download", [AdminPageController::class, "download"])->name("admin.download.index");
Route::post("/admin/download/python", [AdminPageController::class, "python"])->name("admin.download.python");

Route::get("/admin/genre/create", [GenreController::class, "create"])->name("admin.genre.create");
Route::post("/admin/genre/create/store", [GenreController::class, "store"])->name("admin.genre.store");

Route::get("/admin/track/create", [AdminPageController::class, "adminCreate"])->name("admin.track.create");
Route::get("/admin/track/create/store", [AdminPageController::class, "store"])->name("admin.track.store");

Route::get("/admin/playlist/create", [PlaylistController::class, "adminCreate"])->name("admin.playlist.create");
Route::get("/admin/playlist/create/store", [PlaylistController::class, "store"])->name("admin.playlist.store");
// END ROUTES ADMIN


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
