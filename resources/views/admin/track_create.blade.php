@extends('admin.base')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-10">

        <h1 class="text-3xl font-bold mb-6">Добавить трек</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.genre.store') }}">
            @csrf
            <div class="mb-6">
                <label for="name" class="block font-semibold mb-1">Название</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required
                    placeholder="Введите имя"/>
            </div>

            <button type="submit" class="bg-black text-white px-6 py-3 rounded text-lg font-semibold hover:bg-gray-800 transition">
                Создать трек
            </button>
        </form>
    </div>
@endsection
