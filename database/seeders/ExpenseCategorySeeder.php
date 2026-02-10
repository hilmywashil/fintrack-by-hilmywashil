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
            // Kebutuhan pokok
            'makan_minum',
            'sembako',
            'kebutuhan_rumah',
            'kesehatan',
            'pendidikan',

            // Transportasi
            'transportasi',
            'bensin',
            'parkir_tol',
            'ojek_taxi',
            'servis_kendaraan',

            // Tagihan rutin
            'listrik',
            'air',
            'internet',
            'pulsa',
            'langganan',

            // Gaya hidup
            'gaya_hidup',
            'hiburan',
            'hobi',
            'traveling',
            'fashion',
            'kopi_jajan',

            // Keuangan
            'tabungan',
            'investasi',
            'cicilan',
            'asuransi',

            // Sosial
            'donasi',
            'kado',
            'keluarga',
            'teman',

            // Cadangan
            'darurat',
            'lainnya',
        ];
        foreach ($items as $item) {
            ExpenseCategory::create(['name' => $item]);
        }
    }
}
