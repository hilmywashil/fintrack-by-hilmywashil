<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'makan_minum',
            'transportasi',
            'belanja_kebutuhan',
            'gaya_hidup',
            'hiburan',
            'tagihan',
            'transfer',
            'donasi',
            'lainnya'
        ];

        foreach ($items as $item) {
            ExpenseCategory::create(['name' => $item]);
        }
    }
}
