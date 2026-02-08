<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'income_category_id' => 'required_if:type,income|exists:income_categories,id',
            'expense_category_id' => 'required_if:type,expense|exists:expense_categories,id',
        ]);

        $transaction = Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }
}
