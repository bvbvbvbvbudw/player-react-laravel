import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout.jsx";

export default function SearchResults() {
    const { query, tracks, playlists, users } = usePage().props;

    return (
        <MainLayout>
            <h1 className="text-2xl mb-4">Результаты поиска: "{query}"</h1>

            <section className="mb-6">
                <h2 className="text-xl mb-2">Треки</h2>
                {tracks.length > 0 ? (
                    <ul>
                        {tracks.map(track => (
                            <li key={track.id}>
                                <Link href={`/tracks/${track.id}`} className="text-blue-600 hover:underline">
                                    {track.name} — {track.artist}
                                </Link>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <p>Треки не найдены.</p>
                )}
            </section>

            <section className="mb-6">
                <h2 className="text-xl mb-2">Плейлисты</h2>
                {playlists.length > 0 ? (
                    <ul>
                        {playlists.map(pl => (
                            <li key={pl.id}>
                                <Link href={`/playlist/${pl.id}`} className="text-blue-600 hover:underline">
                                    {pl.name}
                                </Link>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <p>Плейлисты не найдены.</p>
                )}
            </section>

            <section>
                <h2 className="text-xl mb-2">Пользователи</h2>
                {users.length > 0 ? (
                    <ul>
                        {users.map(user => (
                            <li key={user.id}>
                                <Link href={`/users/${user.id}`} className="text-blue-600 hover:underline">
                                    {user.name}
                                </Link>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <p>Пользователи не найдены.</p>
                )}
            </section>
        </MainLayout>
    );
}
