<?php

namespace Database\Seeders;

use App\Models\Kota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kota::insert(
            [
                ['id' => 1, 'provinsi_id' => 1, 'nama' => 'Bandung'],
                ['id' => 2, 'provinsi_id' => 1, 'nama' => 'Bekasi'],
                ['id' => 3, 'provinsi_id' => 2, 'nama' => 'Semarang'],
                ['id' => 4, 'provinsi_id' => 2, 'nama' => 'Surakarta'],
                ['id' => 5, 'provinsi_id' => 3, 'nama' => 'Surabaya'],
                ['id' => 6, 'provinsi_id' => 3, 'nama' => 'Malang'],
            ]
        );
    }
}
