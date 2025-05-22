<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadMusicJob;
use App\Jobs\ProcessPlaylistDownload;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AdminPageController extends Controller
{
    public function index()
    {
        return view("admin.index");
    }

    public function genre()
    {
        $genres = Genre::all();
        return view("admin.genre", compact("genres"));
    }

    public function download()
    {
        return view("admin.another_service");
    }


    public function python(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:track,playlist',
            'service' => "required",
            'title' => 'required|string',
            'artist' => 'nullable|string',
        ]);

        DownloadMusicJob::dispatch(
            $validated['service'],
            $validated['type'],
            $validated['title'],
            $validated['artist'] ?? null,
            auth()->id()
        );

        return redirect()->route('admin.download.index')->with('success', 'Задача отправлена в очередь. Музыка скоро появится.');
    }

    public function track()
    {
        $tracks = Track::all();
        return view("admin.track", compact("tracks"));
    }
    public function playlist()
    {
        $playlists = Playlist::with("tracks", "user", "likes")->get();
        return view("admin.playlist", compact("playlists", ));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.user', [
            'users' => $users,
        ]);
    }

    public function editUser(User $user)
    {
        return view('admin.user_edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|max:255',
            'is_admin' => 'nullable|boolean',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->is_admin = $request->has('is_admin') ? 1 : 0;
        $user->save();

        return redirect()->route('admin.user')->with('success', 'Пользователь успешно обновлён');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user')->with('success', 'Пользователь успешно удалён');
    }
}
