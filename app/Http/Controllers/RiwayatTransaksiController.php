<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->translatedFormat('d F Y H:i');
                })
                ->editColumn('total_harga', function ($row) {
                    return 'Rp ' . number_format($row->total_harga, 0, ',', '.');
                })
                ->addColumn('aksi', function ($row) {
                    return '<button onclick="lihatDetail(' . $row->id . ')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Detail</button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('riwayat-transaksi.index');
    }

    public function show($id)
    {
        $details = DetailTransaksi::with('barang')
            ->where('transaksi_id', $id)
            ->get()
            ->map(function ($item) {
                return [
                    'nama_barang' => $item->barang->nama,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->harga_satuan,
                    'subtotal' => $item->subtotal,
                ];
            });

        return response()->json($details);
    }
}
