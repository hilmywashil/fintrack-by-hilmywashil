<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;

class IncomeExpenseController extends Controller
{
    public function incomeIndex()
    {
        $userId = auth()->id();

        $incomes = Transaction::where('type', 'income')->where('user_id', auth()->id())->orderBy('date', 'desc')->paginate(10);

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
        return view('cashflow.income', compact('incomes', 'percentage', 'currentMonthIncome', 'lastMonthIncome'));
    }

    public function expenseIndex()
    {
        $userId = auth()->id();

        $expenses = Transaction::where('type', 'expense')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(10);

        $currentMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        $lastMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', Carbon::now()->subMonth()->month)
            ->whereYear('date', Carbon::now()->subMonth()->year)
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
            'percentageExpense'
        ));
    }
}
