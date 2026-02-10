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
            'bonus',
            'freelance',
            'bisnis',
            'kerja_sampingan',
            'hasil_investasi',
            'bunga',
            'dividen',
            'hadiah',
            'refund',
            'cashback',
            'uang_saku',
            'penjualan_barang',
            'komisi',
            'lainnya'
        ];

        foreach ($items as $item) {
            IncomeCategory::create(['name' => $item]);
        }
    }
}
