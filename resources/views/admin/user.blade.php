@extends('admin.base')

@section('title', 'Пользователи')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Пользователи</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left border-collapse border border-gray-300">
                <thead class="bg-green-200">
                <tr>
                    <th class="py-3 px-4 border border-gray-300">ID</th>
                    <th class="py-3 px-4 border border-gray-300">Имя</th>
                    <th class="py-3 px-4 border border-gray-300">Email</th>
                    <th class="py-3 px-4 border border-gray-300">Админ</th>
                    <th class="py-3 px-4 border border-gray-300">Дата регистрации</th>
                    <th class="py-3 px-4 border border-gray-300 text-center">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr class="border border-gray-300 hover:bg-green-50">
                        <td class="py-2 px-4 border border-gray-300">{{ $user->id }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $user->name }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $user->email }}</td>
                        <td class="py-2 px-4 border border-gray-300">
                            @if($user->is_admin)
                                <span class="text-green-600 font-semibold">Да</span>
                            @else
                                <span class="text-gray-500">Нет</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border border-gray-300">{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="py-2 px-4 border border-gray-300 text-center space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="inline-block px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                                Изменить
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Вы уверены, что хотите удалить пользователя?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700 transition">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-gray-500 text-center">Пользователей нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
