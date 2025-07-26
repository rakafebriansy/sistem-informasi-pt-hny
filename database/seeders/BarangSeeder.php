<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $kategoriIds = \App\Models\Kategori::pluck('id')->toArray();

        $namaBarangList = [
            'Beras Setra Ramos', 'Minyak Goreng Bimoli 2L', 'Gula Pasir Gulaku 1kg', 'Tepung Terigu Segitiga Biru',
            'Mie Instan Indomie Goreng', 'Kopi Kapal Api 165g', 'Susu Kental Manis Indomilk', 'Sabun Lifebuoy 70g',
            'Shampoo Sunsilk 170ml', 'Pasta Gigi Pepsodent 190g', 'Air Mineral Aqua 600ml', 'Sarden ABC 425g',
            'Kecap Manis Bango 275ml', 'Saus Sambal ABC 335ml', 'Teh Celup Sariwangi 25 pcs', 'Tisu Paseo 250 sheets',
            'Pembalut Softex 10 pcs', 'Popok Bayi Sweety Silver M', 'Detergen Rinso 1kg', 'Pembersih Lantai Wipol 780ml',
            'Snack Chitato Sapi Panggang', 'Biskuit Roma Kelapa', 'Coklat SilverQueen 65g', 'Minuman Isotonik Pocari Sweat',
            'Susu UHT Ultra Milk 1L', 'Roti Tawar Sari Roti', 'Telur Ayam Ras 1kg', 'Mentega Blue Band 200g',
            'Sabun Cuci Sunlight 800ml', 'Kopi ABC Susu', 'Mi Sedap Ayam Bawang', 'Susu Bear Brand', 'Air Mineral Le Minerale 600ml',
            'Minyak Goreng Fortune 1L', 'Sirup Marjan Cocopandan', 'Coklat Beng-Beng 5 pcs', 'Sosis Kanzler Mini', 
            'Sereal Koko Krunch', 'Corned Beef Pronas', 'Tepung Bumbu Sajiku Ayam Goreng'
        ];

        foreach ($namaBarangList as $namaBarang) {
            $hargaBeli = $faker->numberBetween(5000, 100000);
            Barang::create([
                'kode' => strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(5)),
                'nama' => $namaBarang,
                'kategori_id' => $faker->randomElement($kategoriIds),
                'stok' => $faker->numberBetween(10, 200),
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaBeli + $faker->numberBetween(2000, 50000),
            ]);
        }
    }
}
