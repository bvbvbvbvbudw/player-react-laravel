import os
import yt_dlp
from typing import Optional
from models import MusicService, Track, Playlist

class DummyMusicService(MusicService):
    def search_track(self, title: str, artist: Optional[str] = None) -> Optional[str]:
        print(f"[Dummy] Ищем трек: {title}, артист: {artist}")
        return f"https://dummy.service/{title.replace(' ', '_')}.mp3"

    def download_track(self, url: str, save_path: str) -> None:
        print(f"[Dummy] Скачиваем {url} → {save_path}")
        os.makedirs(os.path.dirname(save_path), exist_ok=True)
        with open(save_path, 'w') as f:
            f.write("FAKE AUDIO CONTENT")

    def search_playlist(self, name: str) -> Optional[Playlist]:
        print(f"[Dummy] Ищем плейлист: {name}")
        return Playlist(name, [
            Track("Song One", "Artist A"),
            Track("Song Two", "Artist B"),
        ])

class SoundCloudService(MusicService):
    def __init__(self):
        self.ydl_opts = {
            'format': 'bestaudio/best',
            'quiet': True,
            'nocheckcertificate': True,
            'postprocessors': [],  # Отключаем ffmpeg, чтобы не было ошибки
            'outtmpl': '%(title)s.%(ext)s',
        }

    def search_track(self, title: str, artist: Optional[str] = None) -> Optional[str]:
        query = f"{title} {artist or ''}".strip()
        print(f"[SoundCloudService] Ищем трек: {query}")
        search_url = f"scsearch1:{query}"

        with yt_dlp.YoutubeDL(self.ydl_opts) as ydl:
            try:
                result = ydl.extract_info(search_url, download=False)
                if 'entries' in result and len(result['entries']) > 0:
                    first = result['entries'][0]
                    print(f"[SoundCloudService] Найден трек: {first.get('title')}")
                    return first.get('webpage_url')
                else:
                    print("[SoundCloudService] Трек не найден")
                    return None
            except Exception as e:
                print(f"[SoundCloudService] Ошибка при поиске: {e}")
                return None

    def download_track(self, url: str, save_path: str) -> None:
        print(f"[SoundCloudService] Скачиваем трек: {url}")
        opts = self.ydl_opts.copy()
        opts['outtmpl'] = save_path

        with yt_dlp.YoutubeDL(opts) as ydl:
            try:
                ydl.download([url])
                print("[SoundCloudService] Скачивание завершено")
            except Exception as e:
                print(f"[SoundCloudService] Ошибка при скачивании: {e}")

    def search_playlist(self, name: str) -> Optional[Playlist]:
        print(f"[SoundCloudService] Ищем плейлист: {name}")
        search_url = f"scsearch5:{name}"

        with yt_dlp.YoutubeDL(self.ydl_opts) as ydl:
            try:
                result = ydl.extract_info(search_url, download=False)
                if 'entries' in result and len(result['entries']) > 0:
                    # Возьмём первый плейлист в результатах
                    playlist_info = None
                    for entry in result['entries']:
                        if entry.get('extractor_key') == 'SoundcloudPlaylist':
                            playlist_info = entry
                            break
                    if not playlist_info:
                        print("[SoundCloudService] Плейлист не найден")
                        return None

                    tracks = []
                    for track_info in playlist_info.get('entries', []):
                        tracks.append(Track(track_info.get('title', 'No Title'), track_info.get('artist', 'Unknown')))
                    playlist = Playlist(
                        name=playlist_info.get('title', 'No Title'),
                        tracks=tracks
                    )
                    print(f"[SoundCloudService] Найден плейлист: {playlist.name}, треков: {len(tracks)}")
                    return playlist
                else:
                    print("[SoundCloudService] Плейлист не найден")
                    return None
            except Exception as e:
                print(f"[SoundCloudService] Ошибка при поиске плейлиста: {e}")
                return None
