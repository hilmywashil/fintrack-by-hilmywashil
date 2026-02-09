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
            'food_and_drinks',      // makan_minum
            'transportation',       // transportasi
            'shopping',             // belanja_kebutuhan
            'lifestyle',            // gaya_hidup
            'entertainment',        // hiburan
            'bills',                // tagihan
            'transfers',            // transfer
            'donation',             // donasi
            'others'                // lainnya
        ];

        foreach ($items as $item) {
            ExpenseCategory::create(['name' => $item]);
        }
    }
}
