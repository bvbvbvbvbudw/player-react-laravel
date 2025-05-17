import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout.jsx";

export default function Home({ stats, recentTracks }) {
    return (
        <>
            <MainLayout>
                <Head title="Главная" />
                <div className="max-w-6xl mx-auto px-4 py-10 space-y-12">
                    <section className="text-center">
                        <h1 className="text-4xl font-bold text-gray-900">🎧 Добро пожаловать в MyMusic</h1>
                        <p className="mt-4 text-lg text-gray-600">Слушайте музыку, загружайте треки, создавайте плейлисты и делитесь ими с другими!</p>
                    </section>
                    <section className="grid md:grid-cols-3 gap-6">
                        <FeatureCard
                            icon="📤"
                            title="Загрузка треков"
                            description="Загружайте свои MP3-файлы (до 10MB) и делитесь с другими."
                        />
                        <FeatureCard
                            icon="📁"
                            title="Создание плейлистов"
                            description="Создавайте и настраивайте собственные музыкальные коллекции."
                        />
                        <FeatureCard
                            icon="❤️"
                            title="Лайки и поиск"
                            description="Ставьте лайки на любимые треки и ищите по жанрам, артистам и названиям."
                        />
                    </section>
                    <section>
                        <h2 className="text-2xl font-semibold mb-4">📊 Статистика</h2>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <StatCard label="Пользователей" value={stats.users} />
                            <StatCard label="Треков" value={stats.tracks} />
                            <StatCard label="Плейлистов" value={stats.playlists} />
                            <StatCard label="Лайков" value={stats.likes} />
                        </div>
                    </section>
                    <section>
                        <h2 className="text-2xl font-semibold mb-4">🆕 Новые треки</h2>
                        <div className="grid md:grid-cols-2 gap-4">
                            {recentTracks.length > 0 ? (
                                recentTracks.map(track => (
                                    <div key={track.id} className="p-4 bg-white rounded shadow">
                                        <h3 className="text-lg font-semibold">{track.title} - {track.artist}</h3>
                                        <audio controls className="mt-2 w-full">
                                            <source src={`/storage/tracks/${track.file_path}`} type="audio/mpeg" />
                                            Ваш браузер не поддерживает аудио.
                                        </audio>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-600">Нет новых треков.</p>
                            )}
                        </div>
                    </section>
                </div>
            </MainLayout>
        </>
    );
}

const FeatureCard = ({ icon, title, description }) => (
    <div className="bg-white p-6 rounded shadow text-center">
        <div className="text-4xl mb-2">{icon}</div>
        <h3 className="text-xl font-semibold">{title}</h3>
        <p className="text-gray-600 mt-2">{description}</p>
    </div>
);

const StatCard = ({ label, value }) => (
    <div className="bg-gray-100 p-4 rounded">
        <p className="text-3xl font-bold text-gray-900">{value}</p>
        <p className="text-gray-600">{label}</p>
    </div>
);
