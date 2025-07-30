<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Pengiriman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

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
        return view('pengiriman.index', compact('pelanggans', 'kotas', 'layanans'));
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
            'kode' => 'required',
            'berat' => 'required',
            'tanggal' => 'required',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $ongkos = $layanan->tarif_per_kg * $request->berat;
        $adminFee = 2000;
        $admin = User::latest()->firstOrFail();

        Pengiriman::create([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'berat' => $request->berat,
            'ongkir' => $ongkos,
            'total_bayar' => $ongkos + $adminFee,
            'status' => 'dikemas',
            'pengirim_id' => $request->pengirim_id,
            'penerima_id' => $request->penerima_id,
            'layanan_id' => $request->layanan_id,
            'kota_asal_id' => $request->kota_asal_id,
            'kota_tujuan_id' => $request->kota_tujuan_id,
            'user_id' => $admin->id,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengiriman = Pengiriman::with(['pengirim', 'penerima', 'kotaAsal', 'kotaTujuan', 'layanan', 'user'])->findOrFail($id);

        return response()->json([
            'kode' => $pengiriman->kode,
            'tanggal' => $pengiriman->tanggal,
            'berat' => $pengiriman->berat,
            'ongkir' => $pengiriman->ongkir,
            'total_bayar' => $pengiriman->total_bayar,
            'status' => $pengiriman->status,
            'pengirim_id' => $pengiriman->pengirim->nama ?? '-',
            'penerima_id' => $pengiriman->penerima->nama ?? '-',
            'layanan_id' => $pengiriman->layanan->nama ?? '-',
            'kota_asal_id' => $pengiriman->kotaAsal->nama ?? '-',
            'kota_tujuan_id' => $pengiriman->kotaTujuan->nama ?? '-',
            'user_id' => $pengiriman->user->name ?? '-',
        ]);
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

    public function showRiwayat(Request $request)
    {
        if ($request->ajax()) {
            $data = Pengiriman::with(['kotaAsal', 'kotaTujuan', 'pengirim', 'penerima'])->select([
                'id',
                'kode',
                'tanggal',
                'berat',
                'ongkir',
                'total_bayar',
                'status',
                'pengirim_id',
                'penerima_id',
                'layanan_id',
                'kota_asal_id',
                'kota_tujuan_id',
                'user_id',
                'created_at'
            ]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pengirim', function ($row) {
                    return $row->pengirim->nama ?? '';
                })
                ->addColumn('penerima', function ($row) {
                    return $row->penerima->nama ?? '';
                })
                ->addColumn('kota_asal', function ($row) {
                    return $row->kotaAsal->nama ?? '';
                })
                ->addColumn('kota_tujuan', function ($row) {
                    return $row->kotaTujuan->nama ?? '';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex gap-2">
                            <button onclick="fetchDetail(' . $row->id . ')" style="background-color: blue; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;"">Detail</button>
                        </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('riwayat-pengiriman.index');
    }
}
