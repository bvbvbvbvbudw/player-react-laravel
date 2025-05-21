@extends('admin.base')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-10">

        <h1 class="text-3xl font-bold mb-6">Добавить депозит пользователю</h1>

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

        <form method="POST" action="{{ route('admin.deposits.store') }}">
            @csrf

            <!-- Пользователь -->
            <div class="mb-4">
                <label for="user_id" class="block font-semibold mb-1">Пользователь</label>
                <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="" disabled selected>Выберите пользователя</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} (ID: {{ $user->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- План -->
            <div class="mb-4">
                <label for="plan_type" class="block font-semibold mb-1">План</label>
                <select name="plan_type" id="plan_type" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="" disabled selected>Выберите план</option>
                    @foreach($plans as $key => $plan)
                        <option value="{{ $key }}"
                                data-min-rub="{{ $plan['min']['RUB'] }}"
                                data-max-rub="{{ $plan['max']['RUB'] }}"
                                data-min-usd="{{ $plan['min']['USD'] }}"
                                data-max-usd="{{ $plan['max']['USD'] }}"
                            {{ old('plan_type') == $key ? 'selected' : '' }}>
                            {{ $plan['name'] }} — {{ $plan['percent_per_day'] }}% в день, период {{ $plan['period_days'] }} дней
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Валюта -->
            <div class="mb-4">
                <label for="currency" class="block font-semibold mb-1">Валюта</label>
                <select name="currency" id="currency" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="RUB" {{ old('currency') == 'RUB' ? 'selected' : '' }}>RUB</option>
                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                </select>
            </div>

            <!-- Сумма -->
            <div class="mb-6">
                <label for="amount" class="block font-semibold mb-1">Сумма</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="amount"
                    id="amount"
                    value="{{ old('amount') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required
                    placeholder="Введите сумму"/>
                <p id="amount-range" class="mt-1 text-sm text-gray-600"></p>
            </div>

            <button type="submit" class="bg-black text-white px-6 py-3 rounded text-lg font-semibold hover:bg-gray-800 transition">
                Создать депозит
            </button>
        </form>
    </div>
@endsection
