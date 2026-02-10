<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::withCount('transactions')->get();
        $expenseCategories = ExpenseCategory::withCount('transactions')->get();

        return view('admin.categories.index', compact('incomeCategories', 'expenseCategories'));
    }

}
