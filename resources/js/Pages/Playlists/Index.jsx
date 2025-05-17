import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout.jsx";

export default function MyPlaylists({ playlists }) {
    return (
        <>
            <MainLayout>
                <Head title="Мои плейлисты" />
                <div className="max-w-4xl mx-auto py-10 px-4">
                    <div className="flex justify-between items-center mb-6">
                        <h1 className="text-2xl font-bold">Мои плейлисты</h1>
                        <Link
                            href="/playlists/create"
                            className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        >
                            + Новый плейлист
                        </Link>
                    </div>

                    {playlists.length === 0 ? (
                        <p className="text-gray-600">У вас еще нет плейлистов.</p>
                    ) : (
                        <div className="grid gap-4">
                            {playlists.map((playlist) => (
                                <Link
                                    key={playlist.id}
                                    href={`/my-playlists/${playlist.id}`}
                                    className="block p-4 bg-white shadow rounded hover:bg-gray-50 transition"
                                >
                                    <h2 className="text-xl font-semibold">{playlist.name}</h2>
                                    <p className="text-sm text-gray-600">
                                        {playlist.tracks_count} треков
                                    </p>
                                </Link>
                            ))}
                        </div>
                    )}
                </div>
            </MainLayout>
        </>
    );
}
