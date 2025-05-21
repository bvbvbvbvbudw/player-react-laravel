import os, sys, json, io
from models import Track, Playlist
from services import SoundCloudService, DummyMusicService
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def get_service_by_name(name: str):
    if name == "soundcloud":
        return SoundCloudService()
    elif name == "dummy":
        return DummyMusicService()
    else:
        raise ValueError(f"Неизвестный сервис: {name}")

def save_track(service, title, artist=None):
    url = service.search_track(title, artist)
    if url:
        file_name = f"{artist} - {title}.mp3" if artist else f"{title}.mp3"
        #print("Saving: ", file_name)
        path = os.path.join("storage", "app", "public", "tracks", file_name)
        service.download_track(url, path)
        return {
            "title": title,
            "artist": artist,
            "path": path
        }
    else:
        print("Не удалось найти трек.")
        return None

def save_playlist(service, playlist_name):
    playlist = service.search_playlist(playlist_name)
    result = []
    if playlist:
        for track in playlist.tracks:
            data = save_track(service, track.title, track.artist)
            if data:
                result.append(data)
    else:
        print("Плейлист не найден.")
    return result

def main():
    if len(sys.argv) < 4:
        print("{}", end="")
        return

    service_name = sys.argv[1]
    mode = sys.argv[2]
    title = sys.argv[3]
    artist = sys.argv[4] if len(sys.argv) > 4 else None

    # service_name = "soundcloud"
    # mode = "playlist"
    # # title = "кишлак/апфс все песни + новые"
    # title = "phonk"
    # artist = None

    try:
        service = get_service_by_name(service_name)
    except ValueError as e:
        print(f"{{'error':'{str(e)}'}}", end="")
        return

    if mode == 'track':
        data = save_track(service, title, artist)
        if data:
            print(json.dumps(data, ensure_ascii=False), end="")
        else:
            print("{}", end="")
    elif mode == 'playlist':
        data = save_playlist(service, title)
        print(json.dumps({"tracks": data}, ensure_ascii=False), end="")
    else:
        print("{}", end="")

if __name__ == "__main__":
    main()
