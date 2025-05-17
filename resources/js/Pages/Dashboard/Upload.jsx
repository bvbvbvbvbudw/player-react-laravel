import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';

export default function Upload() {
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        artist: '',
        genre: '',
        audio: null,
        is_public: true,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/tracks/upload', {
            forceFormData: true,
            onSuccess: () => reset(),
        });
    };

    return (
        <>
            <Head title="Загрузка трека" />
            <div className="max-w-2xl mx-auto py-10 px-4">
                <h1 className="text-2xl font-bold mb-6">🎵 Загрузка нового трека</h1>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div>
                        <label className="block mb-1 font-semibold">Название</label>
                        <input
                            type="text"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                            className="w-full border px-3 py-2 rounded"
                        />
                        {errors.title && <p className="text-red-600 text-sm">{errors.title}</p>}
                    </div>

                    <div>
                        <label className="block mb-1 font-semibold">Исполнитель</label>
                        <input
                            type="text"
                            value={data.artist}
                            onChange={(e) => setData('artist', e.target.value)}
                            className="w-full border px-3 py-2 rounded"
                        />
                        {errors.artist && <p className="text-red-600 text-sm">{errors.artist}</p>}
                    </div>

                    <div>
                        <label className="block mb-1 font-semibold">Жанр</label>
                        <input
                            type="text"
                            value={data.genre}
                            onChange={(e) => setData('genre', e.target.value)}
                            className="w-full border px-3 py-2 rounded"
                        />
                        {errors.genre && <p className="text-red-600 text-sm">{errors.genre}</p>}
                    </div>

                    <div>
                        <label className="block mb-1 font-semibold">Аудиофайл</label>
                        <input
                            type="file"
                            accept="audio/*"
                            onChange={(e) => setData('audio', e.target.files[0])}
                            className="w-full"
                        />
                        {errors.audio && <p className="text-red-600 text-sm">{errors.audio}</p>}
                    </div>

                    <div className="flex items-center gap-2">
                        <input
                            type="checkbox"
                            checked={data.is_public}
                            onChange={(e) => setData('is_public', e.target.checked)}
                        />
                        <label className="text-sm">Сделать трек публичным</label>
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
                    >
                        {processing ? 'Загрузка...' : 'Загрузить трек'}
                    </button>
                </form>
            </div>
        </>
    );
}
