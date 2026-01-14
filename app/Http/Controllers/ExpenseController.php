<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:50',
            'date' => 'required|date',
            'is_recurring' => 'boolean',
            'frequency' => 'nullable|required_if:is_recurring,1|string',
            'interval' => 'nullable|required_if:is_recurring,1|integer|min:1',
            'start_date' => 'nullable|required_if:is_recurring,1|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $request->user()->expenses()->create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:50',
            'date' => 'required|date',
            'is_recurring' => 'boolean',
            'frequency' => 'nullable|required_if:is_recurring,1|string',
            'interval' => 'nullable|required_if:is_recurring,1|integer|min:1',
            'start_date' => 'nullable|required_if:is_recurring,1|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle checkbox logic
        $validated['is_recurring'] = $request->has('is_recurring');

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
