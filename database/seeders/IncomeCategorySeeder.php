<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'gaji',
            'freelance',
            'bisnis',
            'hadiah',
            'refund',
            'lainnya'
        ];

        foreach ($items as $item) {
            IncomeCategory::create(['name' => $item]);
        }
    }
}
