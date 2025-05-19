<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        $playlists = $request->user()->playlists()->withCount('tracks')->latest()->get();

        return Inertia::render('Playlists/Index', [
            'playlists' => $playlists,
        ]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $playlist = Playlist::findOrFail($id);
        $playlist->load('tracks');
        $isCreator = $user->id === $playlist->user_id;

        $allTracks = Track::where('user_id', auth()->id())
            ->whereNotIn('id', $playlist->tracks->pluck('id'))
            ->get(['id', 'title', 'artist', "plays"]);

        return Inertia::render('Playlists/Show', [
            'playlist' => $playlist,
            'allTracks' => $allTracks,
            'isCreator' => $isCreator,
        ]);
    }

    public function create()
    {
        return Inertia::render('Playlists/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist = auth()->user()->playlists()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Плейлист создан!');
    }

    public function addTrack(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'track_id' => ['required', 'exists:tracks,id'],
        ]);

        if (!$playlist->tracks()->where('track_id', $request->track_id)->exists()) {
            $playlist->tracks()->attach($request->track_id);
        }

        return redirect()->back()->with('success', 'Трек добавлен в плейлист');
    }

    public function toggleLike(Request $request, Playlist $playlist)
    {
        $user = $request->user();

        $existingLike = $playlist->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $playlist->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likesCount' => $playlist->likes()->count(),
        ]);
    }
}
