@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Add New Expense
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Log a new expense.
        </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-6 sm:px-6 sm:py-5">
            @csrf

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                    <input type="text" name="description" id="description" value="{{ old('description') }}" required
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                </div>
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" name="amount" id="amount" step="0.01" value="{{ old('amount') }}" required
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="0.00">
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                    <option value="">Select Category</option>
                    <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food</option>
                    <option value="Transportation" {{ old('category') == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                    <option value="Entertainment" {{ old('category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                    <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                    <option value="Orders" {{ old('category') == 'Orders' ? 'selected' : '' }}>Orders</option>
                    <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>Health</option>
                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <div class="mt-1">
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                </div>
            </div>

            <!-- Recurring Checkbox -->
            <div class="relative flex items-start">
                <div class="flex items-center h-5">
                    <input id="is_recurring" name="is_recurring" type="checkbox" value="1" {{ old('is_recurring') ? 'checked' : '' }}
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="is_recurring" class="font-medium text-gray-700">Recurring Expense?</label>
                    <p class="text-gray-500">Check this if this expense repeats periodically.</p>
                </div>
            </div>

            <!-- Recurring Fields Container -->
            <div id="recurring_fields" class="space-y-6 pt-4 border-t border-gray-200 {{ old('is_recurring') ? '' : 'hidden' }}">
                <h4 class="text-md font-medium text-gray-900">Recurring Details</h4>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <!-- Frequency -->
                    <div>
                        <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency</label>
                        <select id="frequency" name="frequency" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                            <option value="">Select Frequency</option>
                            <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>

                    <!-- Interval -->
                    <div>
                        <label for="interval" class="block text-sm font-medium text-gray-700">Interval</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="number" name="interval" id="interval" min="1" value="{{ old('interval', 1) }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 p-2 border">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                (s)
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">e.g., Every 2 weeks</p>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date (Optional)</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('expenses.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Expense
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('is_recurring');
        const fields = document.getElementById('recurring_fields');

        function toggleFields() {
            if (checkbox.checked) {
                fields.classList.remove('hidden');
            } else {
                fields.classList.add('hidden');
            }
        }

        checkbox.addEventListener('change', toggleFields);
    });
</script>
@endsection
