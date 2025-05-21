@extends('admin.base')

@section('content')
    <div class="max-w-6xl mx-auto p-6 bg-white rounded shadow mt-10">

        <h1 class="text-3xl font-bold mb-6">Список жанров</h1>

        <form method="GET" action="{{ route('admin.genre') }}" class="mb-6 flex flex-wrap gap-4 items-end">

            <div>
                <label for="genre_name" class="block font-semibold mb-1">Жанр</label>
                <input name="genre_name" id="genre_name" type="text" class="border border-gray-300 rounded px-3 py-2" placeholder="Название жанра">
            </div>

{{--            <div>--}}
{{--                <label for="plan_type" class="block font-semibold mb-1">План</label>--}}
{{--                <select name="plan_type" id="plan_type" class="border border-gray-300 rounded px-3 py-2">--}}
{{--                    <option value="">Все</option>--}}
{{--                    @foreach($plans as $key => $plan)--}}
{{--                        <option value="{{ $key }}" {{ request('plan_type') == $key ? 'selected' : '' }}>--}}
{{--                            {{ $plan['name'] }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

            <button type="submit" class="bg-black text-white px-5 py-2 rounded font-semibold hover:bg-gray-800 transition">
                Фильтровать
            </button>

            <a href="{{ route("admin.genre.create") }}" class="bg-black text-white px-5 py-2 rounded font-semibold hover:bg-gray-800 transition">Создать</a>
            <a href="{{ route('admin.genre') }}" class="ml-4 underline text-gray-600 hover:text-gray-900">Сбросить</a>
        </form>

        @if($genres)
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Имя</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($genres as $genre)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $genre->id }}</td>

                        <td class="border border-gray-300 px-4 py-2">{{ $genre->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">изменить удалить</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
{{--                {{ $deposits->links() }}--}}
            </div>
        @else
            <p>Жанры не найдены.</p>
        @endif

    </div>
@endsection
