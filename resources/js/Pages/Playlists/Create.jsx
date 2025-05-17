import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import MainLayout from "@/Layouts/MainLayout.jsx";

export default function Create({ auth }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('playlists.store'));
    };

    return (
        <MainLayout>
            <Head title="Создать плейлист" />
            <div className="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
                <h1 className="text-2xl font-bold mb-4">➕ Создать плейлист</h1>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">
                            Название плейлиста
                        </label>
                        <input
                            type="text"
                            className="mt-1 block w-full border rounded px-3 py-2"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                        />
                        {errors.name && (
                            <p className="text-sm text-red-500 mt-1">{errors.name}</p>
                        )}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                    >
                        Создать
                    </button>
                </form>
            </div>
        </MainLayout>
    );
}
