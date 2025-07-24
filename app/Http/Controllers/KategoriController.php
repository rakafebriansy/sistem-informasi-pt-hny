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
                ->editColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->translatedFormat('d F Y H:i');
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <button onclick="deleteKategori(' . $row->id . ')" style="background-color: red; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                            Hapus
                        </button>
                        <form id="form-delete-' . $row->id . '" method="POST" action="' . route('kategori.destroy', $row->id) . '" style="display:none;">
                            ' . csrf_field() . method_field('DELETE') . '
                        </form>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('kategori.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris',
        ]);

        Kategori::create($request->only('nama'));

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
