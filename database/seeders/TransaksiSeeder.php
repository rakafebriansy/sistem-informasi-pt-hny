<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangList = Barang::all();

        for ($i = 1; $i <= 120; $i++) {
            $kode = 'TRX-' . strtoupper(Str::random(6));
            $tanggal = Carbon::now()->subDays(rand(0, 30))->setTime(rand(8, 20), rand(0, 59), 0);

            $transaksi = Transaksi::create([
                'kode' => $kode,
                'total_harga' => 0, 
                'keterangan' => 'Transaksi otomatis #' . $i,
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ]);

            $total = 0;
            $jumlahDetail = rand(1, 5);
            $barangDipilih = $barangList->random($jumlahDetail);

            foreach ($barangDipilih as $barang) {
                $jumlah = rand(1, 5);
                $harga = $barang->harga_jual;
                $subtotal = $jumlah * $harga;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ]);

                $total += $subtotal;
            }

            $transaksi->update(['total_harga' => $total]);
        }
    }
}
