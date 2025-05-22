@extends('admin.base')

@section('title', 'Редактировать пользователя')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Редактировать пользователя #{{ $user->id }}</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Имя</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="email" class="block font-semibold mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="password" class="block font-semibold mb-1">Пароль</label>
            <input type="text" id="password" name="password" placeholder="Введите пароль"
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>


        <div class="mb-6">
            <label for="is_admin" class="inline-flex items-center">
                <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }} class="mr-2">
                Администратор
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 transition">
                Сохранить
            </button>
            <a href="{{ route('admin.users') }}" class="px-5 py-2 border border-gray-300 rounded hover:bg-gray-100 transition">
                Отмена
            </a>
        </div>
    </form>
@endsection
