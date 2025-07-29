<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Provinsi::select(['id', 'nama', 'created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex gap-2">
                            <button onclick="editProvinsi(' . $row->id . ', \'' . e($row->nama) . '\')" style="background-color: #FFCA2C; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Edit
                            </button>

                            <button onclick="deleteProvinsi(' . $row->id . ')" style="background-color: #BB2D3B; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Hapus
                            </button>

                            <form id="form-delete-' . $row->id . '" method="POST" action="' . route('provinsi.destroy', $row->id) . '" style="display:none;">
                                ' . csrf_field() . method_field('DELETE') . '
                            </form>
                        </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('provinsi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:provinsis,nama',
        ]);

        $provinsi = Provinsi::create(['nama' => $request->nama]);

        return response()->json([
            'success' => true,
            'message' => 'Provinsi berhasil ditambahkan',
            'data' => $provinsi,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return response()->json($provinsi);
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
        $provinsi = Provinsi::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:provinsis,nama,' . $provinsi->id,
        ]);

        $provinsi->update(['nama' => $request->nama]);

        return response()->json([
            'success' => true,
            'message' => 'Provinsi berhasil diupdate',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $provinsi = Provinsi::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Provinsi berhasil dihapus',
        ]);
    }
}
