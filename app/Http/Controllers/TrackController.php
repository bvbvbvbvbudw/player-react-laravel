<?php
namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TrackController extends Controller
{
    public function myTracks()
    {
        $tracks = auth()->user()->tracks()->latest()->get();

        return Inertia::render('Dashboard/MyTracks', [
            'tracks' => $tracks,
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'audio' => 'required|file|mimes:mp3,wav,ogg|max:20480',
            'is_public' => 'boolean',
        ]);

        $path = $request->file('audio')->store('tracks', 'public');

        $track = \App\Models\Track::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'genre' => $request->genre,
            'file_path' => $path,
            'user_id' => auth()->id(),
            'is_public' => $request->is_public ?? true,
            'plays' => 0,
            'likes' => 0,
        ]);

        return redirect('/dashboard')->with('success', 'Трек успешно загружен!');
    }

    public function incrementPlays(Track $track)
    {
        $track->increment('plays');
        return response()->json(['plays' => $track->plays]);
    }

    public function toggleLike(Request $request, Track $track)
    {
        $user = $request->user();

        $existingLike = $track->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Удаляем лайк
            $existingLike->delete();
            $track->decrement('likes');
            $liked = false;
        } else {
            // Добавляем лайк
            $track->likes()->create(['user_id' => $user->id]);
            $track->increment('likes');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likesCount' => $track->likes,
        ]);
    }
}
