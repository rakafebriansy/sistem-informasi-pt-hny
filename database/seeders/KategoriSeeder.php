<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriNames = [
            'Elektronik',
            'Pakaian',
            'Makanan',
            'Minuman',
            'Buku',
            'Alat Tulis',
            'Aksesoris',
            'Perabotan',
            'Kecantikan',
            'Olahraga'
        ];

        foreach ($kategoriNames as $name) {
            Kategori::create([
                'nama' => $name,
            ]);
        }

    }
}
