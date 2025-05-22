<?php
namespace App\Jobs;

use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DownloadMusicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $service;
    public string $type;
    public string $title;
    public ?string $artist;
    public ?int $userId;

    public function __construct(string $service, string $type, string $title, ?string $artist = null, ?int $userId = null)
    {
        $this->service = $service;
        $this->type = $type;
        $this->title = $title;
        $this->artist = $artist;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $args = [$this->service, $this->type, $this->title];
        if ($this->artist) {
            $args[] = $this->artist;
        }

        $python_path = "C:\\Users\\dsada\\AppData\\Local\\Programs\\Python\\Python313\\python.EXE";
        $pythonScript = base_path('app/Service/music_downloader/main.py');
        $env = array_merge($_ENV, $_SERVER, ['SystemRoot' => getenv('SystemRoot')]);

        $process = new Process(array_merge([$python_path, $pythonScript], $args), base_path(), $env);
        $process->setWorkingDirectory(base_path());
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error('Python script failed: ' . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        $outputRaw = $process->getOutput();
        Log::info("[Python output]: " . $outputRaw);

        $lines = explode("\n", trim($outputRaw));
        $lastLine = trim(end($lines));
        $output = json_decode($lastLine, true);

        if ($this->type === 'track') {
            $relativePath = str_replace('storage\\app\\public\\', '', $output['path']);
            Track::create([
                'title' => $output['title'],
                'artist' => $output['artist'],
                'file_path' => $relativePath,
                'user_id' => $this->userId,
                'is_public' => true,
                'genre_id' => null,
                'plays' => 0,
                'likes' => 0,
            ]);
        } elseif ($this->type === 'playlist') {
            $playlist = Playlist::create([
                'name' => $this->title,
                'user_id' => $this->userId,
                'is_public' => true,
            ]);

            foreach ($output['tracks'] as $trackData) {
                $relativePath = str_replace('storage\\app\\public\\', '', $trackData['path']);
                $track = Track::create([
                    'title' => $trackData['title'],
                    'artist' => $trackData['artist'],
                    'file_path' => $relativePath,
                    'user_id' => $this->userId,
                    'is_public' => true,
                    'genre_id' => null,
                    'plays' => 0,
                    'likes' => 0,
                ]);
                $playlist->tracks()->attach($track->id);
            }
        }
    }
}
