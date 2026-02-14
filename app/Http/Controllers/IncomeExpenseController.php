<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;

class IncomeExpenseController extends Controller
{
    public function incomeIndex(Request $request)
    {
        $userId = auth()->id();

        $query = Transaction::where('user_id', $userId)
            ->where('type', 'income');

        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->category) {
            $query->where('income_category_id', $request->category);
        }

        $incomes = $query
            ->with('incomeCategory')
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $categories = IncomeCategory::all();

        $currentMonthIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        $lastMonthIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', Carbon::now()->subMonth()->month)
            ->whereYear('date', Carbon::now()->subMonth()->year)
            ->sum('amount');

        if ($lastMonthIncome > 0) {
            $percentage = (($currentMonthIncome - $lastMonthIncome) / $lastMonthIncome) * 100;
        } else {
            $percentage = $currentMonthIncome > 0 ? 100 : 0;
        }

        return view('cashflow.income', compact(
            'incomes',
            'percentage',
            'currentMonthIncome',
            'lastMonthIncome',
            'categories'
        ));
    }

    public function expenseIndex(Request $request)
    {
        $userId = auth()->id();

        $categories = ExpenseCategory::all();

        $query = Transaction::where('type', 'expense')
            ->where('user_id', $userId);

        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->category) {
            $query->where('expense_category_id', $request->category);
        }

        $expenses = $query
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $currentMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $lastMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year)
            ->sum('amount');

        if ($lastMonthExpense > 0) {
            $percentageExpense = (($currentMonthExpense - $lastMonthExpense) / $lastMonthExpense) * 100;
        } else {
            $percentageExpense = $currentMonthExpense > 0 ? 100 : 0;
        }

        return view('cashflow.expense', compact(
            'expenses',
            'currentMonthExpense',
            'lastMonthExpense',
            'percentageExpense',
            'categories'
        ));
    }
}
