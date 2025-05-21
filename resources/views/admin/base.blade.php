<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - Админка</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

<aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 border-b">
        <h1 class="text-xl font-bold">Админка</h1>
    </div>
    <nav class="flex-grow px-4 py-6">
        <ul class="space-y-4">
            <li><a href="{{ route('admin.index') }}" class="block py-2 px-3 rounded hover:bg-green-100 font-semibold @if(request()->routeIs('admin.index')) bg-green-200 @endif">Панель</a></li>
            <li><a href="{{ route('admin.genre') }}" class="block py-2 px-3 rounded hover:bg-green-100 font-semibold @if(request()->routeIs('admin.genre')) bg-green-200 @endif">Жанры</a></li>
            <li><a href="{{ route('admin.index') }}" class="block py-2 px-3 rounded hover:bg-green-100 font-semibold @if(request()->routeIs('admin.index')) bg-green-200 @endif">Треки</a></li>
            <li><a href="{{ route('admin.index') }}" class="block py-2 px-3 rounded hover:bg-green-100 font-semibold @if(request()->routeIs('admin.index')) bg-green-200 @endif">Плейлисты</a></li>
            <li><a href="{{ route('admin.index') }}" class="block py-2 px-3 rounded hover:bg-green-100 font-semibold @if(request()->routeIs('admin.index')) bg-green-200 @endif">Пользователи</a></li>
            <li><a href="{{ route('admin.download.index') }}" class="block py-2 px-3 rounded hover:bg-green-100 font-semibold @if(request()->routeIs('admin.download.index')) bg-green-200 @endif">Подключить с других сервисов</a></li>
        </ul>
    </nav>
    <div class="p-6 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2 px-3 bg-red-500 hover:bg-red-600 text-white rounded">Выйти</button>
        </form>
    </div>
</aside>

<main class="flex-grow p-8">
    @yield('content')
</main>

</body>
</html>
