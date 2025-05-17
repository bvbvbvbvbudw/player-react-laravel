import React from 'react';
import AudioPlayer from '@/Components/AudioPlayer';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout.jsx";

export default function MyTracks({ auth, tracks }) {
    return (
        <MainLayout>
            <Head title="Мои треки" />

            <div className="max-w-4xl mx-auto mt-10 space-y-6">
                <h1 className="text-3xl font-bold text-gray-800">Мои треки</h1>

                {tracks.length === 0 ? (
                    <p className="text-gray-600">У вас пока нет загруженных треков.</p>
                ) : (
                    tracks.map((track) => (
                        <AudioPlayer
                            key={track.id}
                            src={`/storage/${track.file_path}`}
                            title={track.title}
                            artist={track.artist}
                        />
                    ))
                )}
            </div>
        </MainLayout>
    );
}
