@extends('admin.base')

@section('title', 'Панель управления')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Панель управления</h2>

    <!-- Статистика -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Всего пользователей</h3>
{{--            <p class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</p>--}}
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Всего рефералов</h3>
{{--            <p class="text-2xl font-bold">{{ $totalReferrals ?? 0 }}</p>--}}
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Всего пополнений</h3>
{{--            <p class="text-2xl font-bold">{{ number_format($totalDeposits ?? 0, 2, ',', ' ') }} RUB</p>--}}
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Партнёрская программа</h3>
{{--            <p class="text-xl font-medium">10%, 5%, 3%</p>--}}
        </div>
    </div>

    <!-- Таблица рефералов -->
    <section class="bg-white rounded-lg shadow p-6">
        <h3 class="text-2xl font-bold mb-4">Рефералы</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-center border-collapse border border-gray-300">
                <thead class="bg-green-200">
                <tr>
                    <th class="py-3 px-4 border border-gray-300">Логин</th>
                    <th class="py-3 px-4 border border-gray-300">Дата регистрации</th>
                    <th class="py-3 px-4 border border-gray-300">Пополнение</th>
                    <th class="py-3 px-4 border border-gray-300">Реферальные</th>
                    <th class="py-3 px-4 border border-gray-300">Уровень</th>
                </tr>
                </thead>
                <tbody>
                {{--                @forelse($referrals as $ref)--}}
                {{--                    <tr class="border border-gray-300 hover:bg-green-50">--}}
                {{--                        <td class="py-2 px-4 border border-gray-300">{{ $ref->name }}</td>--}}
                {{--                        <td class="py-2 px-4 border border-gray-300">{{ $ref->created_at->format('d.m.Y') }}</td>--}}
                {{--                        <td class="py-2 px-4 border border-gray-300">{{ number_format($ref->deposit ?? 0, 2, ',', ' ') }} RUB</td>--}}
                {{--                        <td class="py-2 px-4 border border-gray-300">{{ number_format($ref->referral_earnings ?? 0, 2, ',', ' ') }} RUB</td>--}}
                {{--                        <td class="py-2 px-4 border border-gray-300">{{ $ref->level }}</td>--}}
                {{--                    </tr>--}}
                {{--                @empty--}}
                <tr>
                    <td colspan="5" class="py-4 text-gray-500">Нет данных</td>
                </tr>
                {{--                @endforelse--}}
                </tbody>
            </table>
        </div>
    </section>
@endsection
