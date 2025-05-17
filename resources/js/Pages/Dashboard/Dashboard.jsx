import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout.jsx";

export default function Dashboard({ stats = {}, tracks = [], playlists = [] }) {
    const safeStats = {
        tracks: stats.tracks || 0,
        playlists: stats.playlists || 0,
        likes: stats.likes || 0,
    };

    return (
        <>
            <MainLayout>
                <Head title="Личный кабинет" />
                <div className="max-w-6xl mx-auto px-4 py-10 space-y-10">
                    <h1 className="text-3xl font-bold">👤 Личный кабинет</h1>

                    {/* User Stats */}
                    <section className="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <StatCard label="Мои треки" value={safeStats.tracks} />
                        <StatCard label="Мои плейлисты" value={safeStats.playlists} />
                        <StatCard label="Лайков получено" value={safeStats.likes} />
                    </section>

                    {/* Tracks Section */}
                    <section>
                        <div className="flex justify-between items-center mb-4">
                            <h2 className="text-xl font-semibold">🎵 Мои треки</h2>
                            <Link
                                href="/tracks/upload"
                                className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                            >
                                ➕ Загрузить
                            </Link>
                        </div>

                        {tracks.length > 0 ? (
                            <div className="overflow-x-auto">
                                <table className="w-full border rounded bg-white">
                                    <thead>
                                    <tr className="bg-gray-100 text-left">
                                        <th className="px-4 py-2">Название</th>
                                        <th className="px-4 py-2">Жанр</th>
                                        <th className="px-4 py-2">Прослушивания</th>
                                        <th className="px-4 py-2">Лайки</th>
                                        <th className="px-4 py-2">Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {tracks.map((track) => (
                                        <tr key={track.id} className="border-t">
                                            <td className="px-4 py-2">{track.title}</td>
                                            <td className="px-4 py-2">{track.genre}</td>
                                            <td className="px-4 py-2">{track.plays}</td>
                                            <td className="px-4 py-2">{track.likes_count}</td>
                                            <td className="px-4 py-2 space-x-2">
                                                <Link
                                                    href={`/tracks/${track.id}/edit`}
                                                    className="text-blue-600 hover:underline"
                                                >
                                                    Редактировать
                                                </Link>
                                                <Link
                                                    href={`/tracks/${track.id}`}
                                                    method="delete"
                                                    as="button"
                                                    className="text-red-600 hover:underline"
                                                >
                                                    Удалить
                                                </Link>
                                            </td>
                                        </tr>
                                    ))}
                                    </tbody>
                                </table>
                            </div>
                        ) : (
                            <p className="text-gray-600">У вас пока нет загруженных треков.</p>
                        )}
                    </section>

                    {/* Playlists Section */}
                    <section>
                        <div className="flex justify-between items-center mb-4">
                            <h2 className="text-xl font-semibold">📁 Мои плейлисты</h2>
                            <Link
                                href="/playlists/create"
                                className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                            >
                                ➕ Новый плейлист
                            </Link>
                        </div>

                        {playlists.length > 0 ? (
                            <ul className="space-y-2">
                                {playlists.map((pl) => (
                                    <li
                                        key={pl.id}
                                        className="p-4 bg-white border rounded flex justify-between items-center"
                                    >
                                        <div>
                                            <h3 className="font-semibold">{pl.name}</h3>
                                            <p className="text-sm text-gray-600">
                                                Треков: {pl.tracks_count}
                                            </p>
                                        </div>
                                        <div className="space-x-2">
                                            <Link
                                                href={`/my-playlists/${pl.id}`}
                                                className="text-blue-600 hover:underline"
                                            >
                                                Открыть
                                            </Link>
                                            <Link
                                                href={`/playlists/${pl.id}`}
                                                method="delete"
                                                as="button"
                                                className="text-red-600 hover:underline"
                                            >
                                                Удалить
                                            </Link>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                        ) : (
                            <p className="text-gray-600">Нет созданных плейлистов.</p>
                        )}
                    </section>
                </div>
            </MainLayout>
        </>
    );
}

function StatCard({ label, value }) {
    return (
        <div className="bg-gray-100 p-4 rounded text-center">
            <p className="text-2xl font-bold">{value}</p>
            <p className="text-gray-700">{label}</p>
        </div>
    );
}
