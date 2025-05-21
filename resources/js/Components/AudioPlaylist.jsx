import React, {useState} from 'react';
import {router} from "@inertiajs/react";

export default function AudioPlaylist({title, user, initialLikes, initialLiked, playlistId}) {
    const [likes, setLikes] = useState(initialLikes || 0);
    const [liked, setLiked] = useState(initialLiked || false);

    const toggleLike = async () => {
        try {
            const response = await axios.post(`/playlists/${playlistId}/toggle-like`);
            setLiked(response.data.liked);
            setLikes(response.data.likesCount);
        } catch (error) {
            console.error('Error toggling like', error);
        }
    };

    return (
        <a href={`playlist/${playlistId}`}>
            <div className="w-full max-w-xl bg-gray-100 rounded-xl shadow-md p-4 mb-4">
                <div className="flex items-center justify-between mb-2">
                    <div>
                        <div className="font-semibold">{title}</div>
                        <div className="text-sm text-gray-600">Создатель: {user.name}</div>
                    </div>
                    <button
                        onClick={(e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            toggleLike();
                        }}
                        className={`px-3 py-1 rounded ${
                            liked ? 'bg-red-500 text-white' : 'bg-gray-300 text-gray-700'
                        }`}
                    >
                        ❤️ {likes}
                    </button>
                </div>
            </div>
        </a>
    );
}
