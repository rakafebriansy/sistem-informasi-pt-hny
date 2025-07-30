<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Layanan::insert(
            [
                ['id' => 1, 'nama' => 'Reguler', 'estimasi_hari' => 4, 'tarif_per_kg' => 10000],
                ['id' => 2, 'nama' => 'Kilat', 'estimasi_hari' => 3, 'tarif_per_kg' => 15000],
                ['id' => 3, 'nama' => 'Same Day', 'estimasi_hari' => 1, 'tarif_per_kg' => 25000],
            ]
        );
    }
}
