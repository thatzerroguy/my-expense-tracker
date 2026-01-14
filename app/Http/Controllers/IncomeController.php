<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incomes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'is_recurring' => 'boolean',
            'frequency' => 'nullable|required_if:is_recurring,1|string',
            'interval' => 'nullable|required_if:is_recurring,1|integer|min:1',
            'start_date' => 'nullable|required_if:is_recurring,1|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $request->user()->incomes()->create($validated);

        return redirect()->route('incomes.index')->with('success', 'Income added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        // Ensure the user owns the income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        return view('incomes.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'is_recurring' => 'boolean',
            'frequency' => 'nullable|required_if:is_recurring,1|string',
            'interval' => 'nullable|required_if:is_recurring,1|integer|min:1',
            'start_date' => 'nullable|required_if:is_recurring,1|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle checkbox logic where unchecked checkboxes aren't sent
        $validated['is_recurring'] = $request->has('is_recurring');

        $income->update($validated);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
