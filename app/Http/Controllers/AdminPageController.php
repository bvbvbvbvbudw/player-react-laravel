<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPlaylistDownload;
use App\Models\Genre;
use App\Models\Track;
use Illuminate\Http\Request;
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

        $type = $validated['type'];
        $service = $validated["service"];
        $title = $validated['title'];
        $artist = $validated['artist'] ?? '';

        $pythonScript = base_path('app\Service\music_downloader\main.py');

        $args = [$service, $type, $title];
        if ($artist) $args[] = $artist;
        $python_path = "C:\\Users\\dsada\\AppData\\Local\\Programs\\Python\\Python313\\python.EXE";
        $env = array_merge($_ENV, $_SERVER, ['SystemRoot' => getenv('SystemRoot')]);

        $process = new Process(array_merge([$python_path, $pythonScript], $args), base_path(), $env);
        $process->setWorkingDirectory(base_path());
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $outputRaw = $process->getOutput();
        Log::info($process->getOutput());

        $lines = explode("\n", trim($outputRaw));
        $lastLine = trim(end($lines));
        $output = json_decode($lastLine, true);

        if ($type === 'track') {
            $relativePath = str_replace('storage\\app\\public\\', '', $output['path']);
            Track::create([
                'title' => $output['title'],
                'artist' => $output['artist'],
                'file_path' => $relativePath,
                'user_id' => auth()->id() ?? null,
                'is_public' => true,
                'genre_id' => null,
                'plays' => 0,
                'likes' => 0,
            ]);
        } elseif ($type === 'playlist') {
            // TODO: добавить инпут колво треков которые парсить в плейлист
            ProcessPlaylistDownload::dispatch($output['tracks'], $output['title'] ?? "Unknown", auth()->id() ?? null);
        }
        return redirect()->route('admin.download.index')->with('success', 'Музыка скачана');
    }
}
