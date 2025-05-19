<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $recentTracks = Track::where('is_public', true)
            ->with(['likes' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->latest()
            ->take(6)
            ->get(['id', 'title', 'artist', 'file_path', "plays"]);

        $recentTracks->transform(function ($track) {
            $track->isLiked = $track->likes->count() > 0;
            unset($track->likes);
            return $track;
        });

        // $recentPlaylists = Playlist::where('is_public', true)->get();
        $recentPlaylists = Playlist::with("user", "tracks")->get();
        foreach ($recentPlaylists as $playlist) {
            // $playlist->isLiked = $playlist->likes->count() > 0;
            $playlist->isLiked = 0;
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
