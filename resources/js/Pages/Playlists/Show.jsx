import React, { useState } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout.jsx";

export default function Show({ playlist, allTracks }) {
    const [selectedTrack, setSelectedTrack] = useState('');
    const { data, setData, post, processing } = useForm({
        track_id: '',
    });
    const handleSubmit = (e) => {
        e.preventDefault();
        post(`/playlists/${playlist.id}/add-track`, {
            track_id: selectedTrack,
            preserveScroll: true,
        });
    };

    return (
        <>
            <MainLayout>
                <Head title={playlist.name} />
                <div className="max-w-4xl mx-auto py-10 px-4">
                    <h1 className="text-2xl font-bold mb-4">{playlist.name}</h1>

                    <form onSubmit={handleSubmit} className="mb-6 flex gap-2 items-center">
                        <select
                            className="border rounded px-2 py-1"
                            value={data.track_id}
                            onChange={e => setData('track_id', e.target.value)}
                        >
                            <option value="">Выберите трек</option>
                            {allTracks.map(track => (
                                <option key={track.id} value={track.id}>
                                    {track.title} — {track.artist}
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

                    <h2 className="text-xl font-semibold mb-2">Треки в плейлисте</h2>
                    {playlist.tracks.length === 0 ? (
                        <p className="text-gray-600">Плейлист пуст.</p>
                    ) : (
                        <ul className="space-y-2">
                            {playlist.tracks.map((track) => (
                                <li key={track.id} className="bg-white p-3 shadow rounded">
                                    <p className="font-medium">{track.title}</p>
                                    <p className="text-sm text-gray-600">{track.artist}</p>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </MainLayout>
        </>
    );
}
