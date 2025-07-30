<?php

namespace Database\Seeders;

use App\Models\Kota;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Pengiriman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengirims = Pelanggan::pluck('id')->toArray();
        $penerimas = $pengirims;
        $layanans = Layanan::pluck('id')->toArray();
        $kotas = Kota::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        if (count($pengirims) < 2 || count($kotas) < 2 || count($layanans) == 0 || count($users) == 0) {
            $this->command->error('Data tidak cukup untuk membuat pengiriman. Minimal 2 pelanggan, 2 kota, 1 layanan, 1 user.');
            return;
        }

        for ($i = 1; $i <= 120; $i++) {
            $pengirim_id = fake()->randomElement($pengirims);
            do {
                $penerima_id = fake()->randomElement($penerimas);
            } while ($penerima_id == $pengirim_id);

            $kota_asal_id = fake()->randomElement($kotas);
            do {
                $kota_tujuan_id = fake()->randomElement($kotas);
            } while ($kota_tujuan_id == $kota_asal_id);

            $berat = fake()->randomFloat(2, 0.5, 50);
            $tarif_per_kg = fake()->numberBetween(4000, 7000);
            $ongkir = $tarif_per_kg * $berat;
            $biaya_tambahan = fake()->numberBetween(5000, 20000);
            $total_bayar = $ongkir + $biaya_tambahan;

            Pengiriman::create([
                'kode' => 'TRX-' . now()->format('YmdHis') . '-' . $i,
                'tanggal' => Carbon::now()->subDays(rand(0, 30))->addMinutes(rand(0, 1440)),
                'berat' => $berat,
                'ongkir' => $ongkir,
                'total_bayar' => $total_bayar,
                'status' => fake()->randomElement(['dikemas', 'dikirim', 'diterima', 'dibatalkan']),
                'pengirim_id' => $pengirim_id,
                'penerima_id' => $penerima_id,
                'layanan_id' => fake()->randomElement($layanans),
                'kota_asal_id' => $kota_asal_id,
                'kota_tujuan_id' => $kota_tujuan_id,
                'user_id' => fake()->randomElement($users),
            ]);
        }
    }
}
