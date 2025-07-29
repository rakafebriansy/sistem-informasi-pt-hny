<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $fillable = [
        'kode',
        'tanggal',
        'berat',
        'ongkos_kirim',
        'total_bayar',
        'status',
        'pengirim_id',
        'penerima_id',
        'layanan_id',
        'kota_asal_id',
        'kota_tujuan_id',
        'user_id'
    ];

    public function pengirim()
    {
        return $this->belongsTo(Pelanggan::class, 'pengirim_id');
    }

    public function penerima()
    {
        return $this->belongsTo(Pelanggan::class, 'penerima_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function kotaAsal()
    {
        return $this->belongsTo(Kota::class, 'kota_asal_id');
    }

    public function kotaTujuan()
    {
        return $this->belongsTo(Kota::class, 'kota_tujuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
