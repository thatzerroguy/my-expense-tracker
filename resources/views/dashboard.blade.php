@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Balance Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Current Balance
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                ${{ number_format($balance, 2) }}
            </dd>
        </div>
    </div>

    <!-- Income Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Income
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-green-600">
                +${{ number_format($totalIncome, 2) }}
            </dd>
        </div>
    </div>

    <!-- Expenses Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Expenses
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-red-600">
                -${{ number_format($totalExpenses, 2) }}
            </dd>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Incomes -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Recent Income
            </h3>
            <a href="{{ route('incomes.create') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Add New</a>
        </div>
        <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
                @forelse($recentIncomes as $income)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-600 truncate">
                                {{ $income->source }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    +${{ number_format($income->amount, 2) }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    {{ $income->date->format('M d, Y') }}
                                </p>
                                @if($income->is_recurring)
                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Recurring ({{ $income->frequency }})
                                    </p>
                                @endif
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-4 sm:px-6 text-gray-500 text-sm">No recent income found.</li>
                @endforelse
            </ul>
        </div>
        @if($recentIncomes->isNotEmpty())
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ route('incomes.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">View all incomes<span aria-hidden="true"> &rarr;</span></a>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Expenses -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Recent Expenses
            </h3>
            <a href="{{ route('expenses.create') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Add New</a>
        </div>
        <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
                @forelse($recentExpenses as $expense)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-600 truncate">
                                {{ $expense->description }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    -${{ number_format($expense->amount, 2) }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <span class="truncate">{{ $expense->category }}</span>
                                    <span class="mx-2">&bull;</span>
                                    {{ $expense->date->format('M d, Y') }}
                                </p>
                                @if($expense->is_recurring)
                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Recurring ({{ $expense->frequency }})
                                    </p>
                                @endif
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-4 sm:px-6 text-gray-500 text-sm">No recent expenses found.</li>
                @endforelse
            </ul>
        </div>
        @if($recentExpenses->isNotEmpty())
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ route('expenses.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">View all expenses<span aria-hidden="true"> &rarr;</span></a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
