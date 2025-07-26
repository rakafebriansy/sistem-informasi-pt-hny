<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kategori::select(['id', 'nama', 'created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
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
        }

        return view('kategori.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris,nama',
        ]);

        $kategori = Kategori::create(['nama' => $request->nama]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori,
        ]);
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json($kategori);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:kategoris,nama,' . $kategori->id,
        ]);

        $kategori->update(['nama' => $request->nama]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus',
        ]);
    }
}
