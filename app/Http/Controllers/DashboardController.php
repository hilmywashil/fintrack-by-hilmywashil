<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $userId = auth()->id();

        $start = now()->subDays(6);
        $end = now();

        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('date', [$start, $end])
            ->select(
                DB::raw('DATE(date) as day'),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
            )
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $days = [];
        $income = [];
        $expense = [];

        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $key = $date->format('Y-m-d');

            $days[] = $date->format('d M');

            $income[] = $transactions[$key]->total_income ?? 0;
            $expense[] = $transactions[$key]->total_expense ?? 0;
        }

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $monthsCount = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->select(DB::raw('YEAR(date) as year'), DB::raw('MONTH(date) as month'))
            ->groupBy('year', 'month')
            ->get()
            ->count();

        $averageMonthlyExpense = $monthsCount > 0
            ? $totalExpense / $monthsCount
            : 0;

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $incomeMonthsCount = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->select(DB::raw('YEAR(date) as year'), DB::raw('MONTH(date) as month'))
            ->groupBy('year', 'month')
            ->get()
            ->count();

        $averageMonthlyIncome = $incomeMonthsCount > 0
            ? $totalIncome / $incomeMonthsCount
            : 0;

        $latestIncomes = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->latest('date')
            ->take(5)
            ->get();

        $latestExpenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->latest('date')
            ->take(5)
            ->get();


        return view('dashboard.index', compact('days', 'income', 'expense', 'totalExpense', 'averageMonthlyExpense', 'totalIncome', 'averageMonthlyIncome', 'latestIncomes', 'latestExpenses'));
    }

    // API JS Chart Data
    public function chartData(Request $request)
    {
        $userId = auth()->id();
        $period = $request->period;

        if ($period == 'month') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } else {
            $days = (int) $period;
            $start = now()->subDays($days - 1);
            $end = now();
        }

        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('date', [$start, $end])
            ->select(
                DB::raw('DATE(date) as day'),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
            )
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $days = [];
        $income = [];
        $expense = [];

        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $key = $date->format('Y-m-d');

            $days[] = $date->format('d M');
            $income[] = $transactions[$key]->total_income ?? 0;
            $expense[] = $transactions[$key]->total_expense ?? 0;
        }

        return response()->json([
            'days' => $days,
            'income' => $income,
            'expense' => $expense
        ]);
    }

}
