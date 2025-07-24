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
                        <form method="POST" action="' . route('kategori.destroy', $row->id) . '" onsubmit="return confirm(\'Yakin?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </form>';
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
