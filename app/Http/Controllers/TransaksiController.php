<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('transaksi.index', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keranjang' => 'required',
        ]);

        $keranjang = json_decode($request->keranjang, true);

        $transaksi = Transaksi::create([
            'kode' => 'TRX-' . Str::upper(Str::random(6)),
            'total_harga' => collect($keranjang)->sum('subtotal'),
            'keterangan' => $request->keterangan,
        ]);

        foreach ($keranjang as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $item['id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan');
    }
}
