<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Barang::select(['id', 'kode_barang', 'nama_barang', 'kategori', 'satuan', 'harga_jual', 'stok']);
            return DataTables::of($data)->make(true);
        }

        return view('kelola-barang.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barang',
            'nama_barang' => 'required',
            'kategori' => 'nullable',
            'satuan' => 'nullable',
            'harga_jual' => 'required|numeric',
        ]);

        Barang::create($request->all());
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }
}
