<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'description',
        'date',
        'income_category_id',
        'expense_category_id'
    ];

    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategory::class);
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
