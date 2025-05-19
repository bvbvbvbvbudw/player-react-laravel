<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $tracks = Track::where('artist', 'like', "%{$query}%")->limit(10)->get();
        $playlists = Playlist::where('name', 'like', "%{$query}%")->limit(10)->get();
        $users = User::where('name', 'like', "%{$query}%")->limit(10)->get();

        return Inertia::render('SearchResults', [
            'query' => $query,
            'tracks' => $tracks,
            'playlists' => $playlists,
            'users' => $users,
        ]);
    }
    public function search(Request $request)
    {
        $q = $request->query('q');

        if (!$q) {
            return response()->json([
                'tracks' => [],
                'playlists' => [],
                'users' => [],
            ]);
        }

        $tracks = Track::where('title', 'like', "%{$q}%")
            ->orWhere('artist', 'like', "%{$q}%")
            ->limit(5)->get();

        $playlists = Playlist::where('name', 'like', "%{$q}%")->with("user")
            ->limit(5)->get();

        $users = User::where('name', 'like', "%{$q}%")
            ->limit(5)->get();

        return response()->json([
            'tracks' => $tracks,
            'playlists' => $playlists,
            'users' => $users,
        ]);
    }
}
