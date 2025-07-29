<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kota::with('provinsi')->select(['id', 'nama', 'provinsi_id', 'created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi_nama', function ($row) {
                    return $row->provinsi->nama ?? '';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex gap-2">
                            <button onclick="editKota(' . $row->id . ')" style="background-color: #FFCA2C; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Edit
                            </button>

                            <button onclick="deleteKota(' . $row->id . ')" style="background-color: #BB2D3B; color: white; padding-left: 0.5rem; padding-right: 0.5rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 0.25rem;">
                                Hapus
                            </button>

                            <form id="form-delete-' . $row->id . '" method="POST" action="' . route('kota.destroy', $row->id) . '" style="display:none;">
                                ' . csrf_field() . method_field('DELETE') . '
                            </form>
                        </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        $provinsiList = Provinsi::all();

        return view('kota.index', compact('provinsiList'));
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
            'nama' => 'required|unique:kotas,nama',
            'provinsi_id' => 'required|exists:provinsis,id',
        ]);

        $kota = Kota::create([
            'nama' => $request->nama,
            'provinsi_id' => $request->provinsi_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kota berhasil ditambahkan',
            'data' => $kota,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kota = Kota::findOrFail($id);
        return response()->json($kota);
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
        $kota = Kota::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:kotas,nama,' . $kota->id,
            'provinsi_id' => 'required|exists:provinsis,id'
        ]);

        $kota->update($request->all());

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kota::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
