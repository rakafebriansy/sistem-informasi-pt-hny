<?php

namespace Database\Seeders;

use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provinsi::insert([
            ['id' => 1, 'nama' => 'Jawa Barat'],
            ['id' => 2, 'nama' => 'Jawa Tengah'],
            ['id' => 3, 'nama' => 'Jawa Timur'],
        ]);
    }
}
