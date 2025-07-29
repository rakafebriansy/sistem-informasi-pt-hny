<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Layanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $kotas = Kota::all();
        $layanans = Layanan::all();
        return view('pengiriman.index', compact('pelanggans','kotas','layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pengirim_id' => 'required|exists:pelanggans,id',
            'penerima_id' => 'required|exists:pelanggans,id',
            'layanan_id' => 'required|exists:layanans,id',
            'kota_asal_id' => 'required|exists:kotas,id',
            'kota_tujuan_id' => 'required|exists:kotas,id',
            'berat' => 'required|numeric|min:0.1',
            'tanggal' => 'required|date',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $ongkos = $layanan->tarif_per_kg * $request->berat;

        Pengiriman::create([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'berat' => $request->berat,
            'ongkos_kirim' => $ongkos,
            'total_bayar' => $ongkos,
            'status' => 'dikemas',
            'pengirim_id' => $request->pengirim_id,
            'penerima_id' => $request->penerima_id,
            'layanan_id' => $request->layanan_id,
            'kota_asal_id' => $request->kota_asal_id,
            'kota_tujuan_id' => $request->kota_tujuan_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
