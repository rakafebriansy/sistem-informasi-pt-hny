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
            $data = Barang::with('kategori')->select(['id', 'kode', 'nama', 'kategori_id', 'satuan', 'harga_jual', 'harga_beli', 'stok']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori_nama', function ($row) {
                    return $row->kategori->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex gap-2">
                            <button onclick="editBarang(' . $row->id . ', \'' . e($row->nama) . '\')" style="background-color: #FFCA2C; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Edit
                            </button>

                            <button onclick="hapusBarang(' . $row->id . ')" style="background-color: #BB2D3B; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
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
        $validator = \Validator::make($request->all(), [
            'kode' => 'required|unique:barangs',
            'nama' => 'required|unique:barangs',
            'kategori_id' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->first()
            ], 422);
        }

        Barang::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan.'
        ]);
    }
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);

        Barang::findOrFail($id)->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
