<?php
namespace App\Jobs;

use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessPlaylistDownload implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, Dispatchable;

    public array $tracks;
    public string $playlistName;
    public $userId;

    public function __construct(array $tracks, string $playlistName, $userId)
    {
        $this->tracks = $tracks;
        $this->playlistName = $playlistName;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $playlist = Playlist::create([
            'name' => $this->playlistName,
            'user_id' => $this->userId,
            'is_public' => true,
        ]);

        foreach ($this->tracks as $trackData) {
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
