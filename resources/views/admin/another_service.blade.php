@extends('admin.base')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Загрузка музыки с сервиса</h1>

        <form method="POST" action="{{ route('admin.download.python') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Сервис:</label>
                <select name="service" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                    <option value="soundcloud">SoundCloud</option>
                    <option value="dummy">Dummy (тестовый)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Тип:</label>
                <select name="type" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                    <option value="track">Трек</option>
                    <option value="playlist">Плейлист</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Название песни / Плейлиста:</label>
                <input name="title" type="text" class="border border-gray-300 rounded px-3 py-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Артист (если трек):</label>
                <input name="artist" type="text" class="border border-gray-300 rounded px-3 py-2 w-full">
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                Скачать
            </button>
        </form>
    </div>
@endsection
