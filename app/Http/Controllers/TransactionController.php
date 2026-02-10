<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
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

        $query = Transaction::where('user_id', auth()->id());

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('date')) {
            $query->whereDate('date', request('date'));
        }
        $transactions = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();
        $incomeCategories = IncomeCategory::all();
        $expenseCategories = ExpenseCategory::all();

        return view('cashflow.index', compact('transactions', 'incomeCategories', 'expenseCategories', 'days', 'income', 'expense'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'income_category_id' => 'nullable',
            'expense_category_id' => 'nullable'
        ]);

        $user = auth()->user();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->type = $validated['type'];
        $transaction->amount = $validated['amount'];
        $transaction->description = $validated['description'];
        $transaction->date = $validated['date'];

        if ($validated['type'] === 'income') {
            $transaction->income_category_id = $request->income_category_id;

            $user->balance += $validated['amount'];

        } else {
            $transaction->expense_category_id = $request->expense_category_id;

            $user->balance -= $validated['amount'];
        }

        $transaction->save();
        $user->save();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction added successfully.');
    }

    public function resetAll()
    {
        $user = auth()->user();

        DB::transaction(function () use ($user) {

            $user->transactions()->delete();

            $user->balance = 0;
            $user->save();
        });

        return back()->with('success', 'Semua data keuangan berhasil dihapus.');
    }
}
