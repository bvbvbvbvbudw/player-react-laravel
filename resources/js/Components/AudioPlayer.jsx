import React, { useRef, useState } from 'react';
import axios from 'axios';

export default function AudioPlayer({ src, title, artist, trackId, initialLikes, initialLiked, initialPlays }) {
    const audioRef = useRef(null);
    const [isPlaying, setIsPlaying] = useState(false);
    const [progress, setProgress] = useState(0);
    const [duration, setDuration] = useState(0);
    const [currentTime, setCurrentTime] = useState(0);
    const [likes, setLikes] = useState(initialLikes || 0);
    const [liked, setLiked] = useState(initialLiked || false);
    const [plays, setPlays] = useState(initialPlays || 0)
    const [playedOnce, setPlayedOnce] = useState(false);

    const togglePlay = () => {
        const audio = audioRef.current;
        if (isPlaying) {
            audio.pause();
        } else {
            audio.play();
            if (!playedOnce) {
                incrementPlays();
                setPlayedOnce(true);
            }
        }
        setIsPlaying(!isPlaying);
    };

    const incrementPlays = async () => {
        try {
            const response = await axios.post(`/tracks/${trackId}/increment-plays`);
            setPlays(response.data.plays)
        } catch (error) {
            console.error('Error incrementing plays', error);
        }
    };

    const toggleLike = async () => {
        try {
            const response = await axios.post(`/tracks/${trackId}/toggle-like`);
            setLikes(response.data.likesCount);
            setLiked(response.data.liked);
        } catch (error) {
            console.error('Error toggling like', error);
        }
    };

    const formatTime = (time) => {
        const minutes = Math.floor(time / 60);
        const seconds = Math.floor(time % 60);
        return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    };

    const handleTimeUpdate = () => {
        const audio = audioRef.current;
        setCurrentTime(audio.currentTime);
        setProgress((audio.currentTime / audio.duration) * 100);
    };

    const handleProgressClick = (e) => {
        const audio = audioRef.current;
        const rect = e.target.getBoundingClientRect();
        const percent = (e.clientX - rect.left) / rect.width;
        audio.currentTime = percent * audio.duration;
    };

    const handleLoadedMetadata = () => {
        setDuration(audioRef.current.duration);
    };

    return (
        <div className="w-full max-w-xl bg-white rounded-2xl shadow-lg p-6 space-y-4">
            <div className="flex items-center justify-between">
                <div>
                    <h3 className="text-lg font-bold text-gray-800">{title}</h3>
                    <p className="text-sm text-gray-500">{artist}</p>
                </div>
                <button
                    onClick={togglePlay}
                    className="text-white bg-blue-600 hover:bg-blue-700 transition-colors rounded-full w-11 h-11 flex items-center justify-center shadow"
                >
                    {isPlaying ? '❚❚' : '▶'}
                </button>
            </div>

            {/* Progress Bar */}
            <div
                className="w-full h-2 bg-gray-200 rounded-full cursor-pointer"
                onClick={handleProgressClick}
            >
                <div
                    className="h-2 bg-blue-500 rounded-full transition-all duration-200"
                    style={{ width: `${progress}%` }}
                />
            </div>

            {/* Time Info */}
            <div className="text-xs text-gray-400 flex justify-between">
                <span>{formatTime(currentTime)}</span>
                <span>{formatTime(duration)}</span>
            </div>

            {/* Likes and Plays */}
            <div className="flex items-center justify-between">
                <button
                    onClick={toggleLike}
                    className={`flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium transition-colors ${
                        liked ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    }`}
                >
                    ❤️ {likes}
                </button>

                <div className="text-sm text-gray-500 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19V6l12-2v13" />
                    </svg>
                    <span>{plays} plays</span>
                </div>
            </div>

            <audio
                ref={audioRef}
                src={src}
                onTimeUpdate={handleTimeUpdate}
                onLoadedMetadata={handleLoadedMetadata}
                onEnded={() => setIsPlaying(false)}
            />
        </div>

    );
}
