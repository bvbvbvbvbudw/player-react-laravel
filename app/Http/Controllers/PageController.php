<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'users' => User::count(),
            'tracks' => Track::count(),
            'playlists' => Playlist::count(),
            'likes' => Like::count(),
        ];

        $recentTracks = Track::with('likes')->where('is_public', true)
            ->latest()
            ->take(6)
            ->get(['id', 'title', 'artist', 'file_path', 'plays']);

        foreach ($recentTracks as $track) {
            $track->likesCount = $track->likes->count();
            $track->isLiked = $userId ? $track->likes->contains('user_id', $userId) : false;
            unset($track->likes);
        }

        $recentPlaylists = Playlist::with("user", "tracks")->get();
        foreach ($recentPlaylists as $playlist) {
            $playlist->isLiked = auth()->user() ? $playlist->likes->contains('user_id', $userId) : false;
            $playlist->likesCount = $playlist->likes->count();
            unset($playlist->likes);
        }

        return Inertia::render('Index', [
            'stats' => $stats,
            'recentTracks' => $recentTracks,
            'recentPlaylists' => $recentPlaylists,
        ]);
    }


    public function dashboard()
    {
        $user = auth()->user()->load('tracks', 'playlists');

        return Inertia::render('Dashboard/Dashboard', [
            'stats' => [
                'tracks' => $user->tracks()->count(),
                'playlists' => $user->playlists()->count(),
                'likes' => $user->tracks()->withCount('likes')->get()->sum('likes_count'),
            ],
            'tracks' => $user->tracks()
                ->withCount('likes')
                ->orderBy('created_at', 'desc')
                ->get(['id', 'title', 'genre', 'plays', 'user_id']),
            'playlists' => $user->playlists()
                ->withCount('tracks')
                ->get(['id', 'name']),
        ]);
    }
}
