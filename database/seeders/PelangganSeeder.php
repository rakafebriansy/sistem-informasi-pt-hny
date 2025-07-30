<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            Pelanggan::create([
                'nama' => fake()->name(),
                'alamat' => fake()->address(),
                'no_hp' => '08' . fake()->numerify('##########'), // 08XXXXXXXXXX
            ]);
        }
    }
}
