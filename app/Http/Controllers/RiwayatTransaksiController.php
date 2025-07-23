<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        return view('riwayat-transaksi.index');
    }
}
