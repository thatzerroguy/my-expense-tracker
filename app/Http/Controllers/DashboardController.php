<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Income;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $recentIncomes = Income::where('user_id', $user->id)
            ->latest('date')
            ->take(5)
            ->get();

        $recentExpenses = Expense::where('user_id', $user->id)
            ->latest('date')
            ->take(5)
            ->get();

        $totalIncome = Income::where('user_id', $user->id)->sum('amount');
        $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');
        $balance = $totalIncome - $totalExpenses;

        return view('dashboard', compact('recentIncomes', 'recentExpenses', 'totalIncome', 'totalExpenses', 'balance'));
    }
}
