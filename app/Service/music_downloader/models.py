from abc import ABC, abstractmethod
from typing import List, Optional

class Track:
    def __init__(self, title: str, artist: str):
        self.title = title
        self.artist = artist

class Playlist:
    def __init__(self, name: str, tracks: List[Track]):
        self.name = name
        self.tracks = tracks

class MusicService(ABC):
    @abstractmethod
    def search_track(self, title: str, artist: Optional[str] = None) -> Optional[str]:
        pass

    @abstractmethod
    def download_track(self, url: str, save_path: str) -> None:
        pass

    @abstractmethod
    def search_playlist(self, name: str) -> Optional[Playlist]:
        pass
