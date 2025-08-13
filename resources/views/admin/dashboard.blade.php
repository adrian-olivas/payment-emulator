<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Управление Транзакциями') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">ID Транзакции</th>
                                <th class="px-6 py-3 text-left">Сумма</th>
                                <th class="px-6 py-3 text-left">Статус</th>
                                <th class="px-6 py-3 text-left">Дата</th>
                                <th class="px-6 py-3 text-right">Действия</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4">{{ $transaction->transaction_id }}</td>
                                    <td class="px-6 py-4">{{ $transaction->amount }} {{ $transaction->currency }}</td>
                                    <td class="px-6 py-4">{{ $transaction->status }}</td>
                                    <td class="px-6 py-4">{{ $transaction->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($transaction->status === 'pending')
                                            <form action="{{ route('admin.transaction.complete', $transaction) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">Подтвердить</button>
                                            </form>
                                            <form action="{{ route('admin.transaction.fail', $transaction) }}" method="POST" class="inline-block ml-4">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900">Отклонить</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Транзакций пока нет.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $transactions->links() }} <!-- Пагинация -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>