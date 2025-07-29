<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Layanan::select(['id', 'nama', 'estimasi_hari', 'tarif_per_kg', 'created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex gap-2">
                            <button onclick="editLayanan(' . $row->id . ')" style="background-color: #FFCA2C; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Edit
                            </button>

                            <button onclick="deleteLayanan(' . $row->id . ')" style="background-color: #BB2D3B; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Hapus
                            </button>

                            <form id="form-delete-' . $row->id . '" method="POST" action="' . route('layanan.destroy', $row->id) . '" style="display:none;">
                                ' . csrf_field() . method_field('DELETE') . '
                            </form>
                        </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('layanan.index');
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
            'nama' => 'required|unique:layanans,nama',
            'estimasi_hari' => 'required',
            'tarif_per_kg' => 'required',
        ]);

        $layanan = Layanan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil ditambahkan',
            'data' => $layanan,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $layanan = Layanan::findOrFail($id);
        return response()->json($layanan);
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
        $layanan = Layanan::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:layanans,nama,' . $layanan->id,
            'estimasi_hari' => 'required',
            'tarif_per_kg' => 'required',
        ]);

        $layanan->update($request->all());

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Layanan::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
