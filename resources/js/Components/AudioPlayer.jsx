import React, { useRef, useState, useEffect } from 'react';
import axios from 'axios';

export default function AudioPlayer({ src, title, artist, trackId, initialLikes, initialLiked, plays }) {
    const audioRef = useRef(null);
    const [isPlaying, setIsPlaying] = useState(false);
    const [progress, setProgress] = useState(0);
    const [duration, setDuration] = useState(0);
    const [currentTime, setCurrentTime] = useState(0);
    const [likes, setLikes] = useState(initialLikes || 0);
    const [liked, setLiked] = useState(initialLiked || false);
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
            await axios.post(`/tracks/${trackId}/increment-plays`);
        } catch (error) {
            console.error('Error incrementing plays', error);
        }
    };

    const toggleLike = async () => {
        try {
            const response = await axios.post(`/tracks/${trackId}/toggle-like`);
            setLikes(response.data.likes);
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
        <div className="w-full max-w-xl bg-gray-100 rounded-xl shadow-md p-4">
            <div className="flex items-center justify-between mb-2">
                <div>
                    <div className="font-semibold">{title}</div>
                    <div className="text-sm text-gray-600">{artist}</div>
                </div>
                <button
                    onClick={togglePlay}
                    className="text-white bg-blue-500 hover:bg-blue-600 rounded-full w-10 h-10 flex items-center justify-center"
                >
                    {isPlaying ? '❚❚' : '▶'}
                </button>
            </div>

            <div
                className="w-full h-2 bg-gray-300 rounded cursor-pointer mb-1"
                onClick={handleProgressClick}
            >
                <div className="h-2 bg-blue-500 rounded" style={{ width: `${progress}%` }}></div>
            </div>

            <div className="text-xs text-gray-500 flex justify-between mb-2">
                <span>{formatTime(currentTime)}</span>
                <span>{formatTime(duration)}</span>
            </div>

            <button
                onClick={toggleLike}
                className={`px-3 py-1 rounded ${
                    liked ? 'bg-red-500 text-white' : 'bg-gray-300 text-gray-700'
                }`}
            >
                ❤️ {likes}
            </button>

            <p>
                {plays}
            </p>

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
