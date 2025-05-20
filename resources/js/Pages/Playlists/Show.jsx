import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout.jsx';
import AudioPlayer from '@/Components/AudioPlayer.jsx';

export default function Show({ playlist, allTracks, isCreator }) {
    const { data, setData, post, processing } = useForm({
        track_id: '',
    });

    const [liked, setLiked] = useState(playlist.isLiked || false);
    const [likesCount, setLikesCount] = useState(playlist.likes_count || 0);

    const handleSubmit = (e) => {
        e.preventDefault();
        post(`/playlists/${playlist.id}/add-track`, {
            preserveScroll: true,
        });
    };

    const handleToggleLike = () => {
        router.post(`/playlists/${playlist.id}/toggle-like`, {}, {
            preserveScroll: true,
            onSuccess: (page) => {
                setLiked(page.props.playlist.isLiked);
                setLikesCount(page.props.playlist.likes_count);
            },
        });
    };

    return (
        <MainLayout>
            <Head title={playlist.name} />
            <div className="max-w-4xl mx-auto py-10 px-4">
                <div className="flex justify-between items-center mb-4">
                    <h1 className="text-2xl font-bold">{playlist.name}</h1>
                    {!isCreator && (
                        <button
                            onClick={handleToggleLike}
                            className={`px-3 py-1 rounded text-white ${liked ? 'bg-red-600' : 'bg-blue-600'} hover:opacity-90`}
                        >
                            {liked ? 'Убрать лайк' : 'Лайкнуть'} ({likesCount})
                        </button>
                    )}
                </div>

                {isCreator && (
                    <form onSubmit={handleSubmit} className="mb-6 flex gap-2 items-center">
                        <select
                            className="border rounded px-2 py-1"
                            value={data.track_id}
                            onChange={e => setData('track_id', e.target.value)}
                        >
                            <option value="">Выберите трек</option>
                            {allTracks.map(track => (
                                <option key={track.id} value={track.id}>
                                    {track.title} — {track.artist} ({track.plays} прослушиваний)
                                </option>
                            ))}
                        </select>
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700"
                        >
                            Добавить
                        </button>
                    </form>
                )}

                <h2 className="text-xl font-semibold mb-2">Треки в плейлисте</h2>
                {playlist.tracks.length === 0 ? (
                    <p className="text-gray-600">Плейлист пуст.</p>
                ) : (
                    <ul className="space-y-4">
                        {playlist.tracks.map((track) => (
                            <AudioPlayer
                                key={track.id}
                                src={`/storage/${track.file_path}`}
                                title={track.title}
                                artist={track.artist}
                                trackId={track.id}
                                initialLikes={track.likes}
                                initialLiked={track.isLiked}
                                initialPlays={track.plays}
                            />
                        ))}
                    </ul>
                )}
            </div>
        </MainLayout>
    );
}
