<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::withCount('transactions')
            ->orderByDesc('transactions_count')
            ->get();

        $expenseCategories = ExpenseCategory::withCount('transactions')
            ->orderByDesc('transactions_count')
            ->get();

        return view('admin.categories.index', compact(
            'incomeCategories',
            'expenseCategories'
        ));
    }
}
