<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Barang::with('kategori')->select(['id', 'kode_barang', 'nama_barang', 'kategori_id', 'satuan', 'harga_jual', 'harga_beli', 'stok']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori_nama', function ($row) {
                    return $row->kategori->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex gap-2">
                            <button onclick="openEditModal(' . $row->id . ', \'' . e($row->nama) . '\')" style="background-color: #FFCA2C; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Edit
                            </button>

                            <button onclick="deleteKategori(' . $row->id . ')" style="background-color: #BB2D3B; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Hapus
                            </button>

                            <form id="form-delete-' . $row->id . '" method="POST" action="' . route('kategori.destroy', $row->id) . '" style="display:none;">
                                ' . csrf_field() . method_field('DELETE') . '
                            </form>
                        </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
            ;
        }

        $kategoriList = Kategori::all();
        return view('kelola-barang.index', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required|unique:barangs',
            'kategori_id' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        Barang::create($request->all());
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }
}
