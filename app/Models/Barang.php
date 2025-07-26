<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $fillable = ['kode', 'nama', 'kategori_id', 'satuan', 'harga_jual', 'harga_beli', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
