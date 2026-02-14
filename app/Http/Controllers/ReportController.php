<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function overview(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');

        $start = Carbon::parse($month)->startOfMonth();
        $end   = Carbon::parse($month)->endOfMonth();

        $totals = Transaction::select(
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->whereBetween('date', [$start, $end])
            ->groupBy('type')
            ->pluck('total', 'type');

        $totalIncome  = $totals['income'] ?? 0;
        $totalExpense = $totals['expense'] ?? 0;
        $balance      = $totalIncome - $totalExpense;

        $transactions = Transaction::whereBetween('date', [$start, $end])
            ->orderBy('date', 'desc')
            ->get();

        return view('reports.overview', compact(
            'month',
            'totalIncome',
            'totalExpense',
            'balance',
            'transactions'
        ));
    }
}
