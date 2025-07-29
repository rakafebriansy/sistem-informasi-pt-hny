<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $fillable = [
        'nama',
        'provinsi_id',
    ];

    public function provinsi() 
    {
        return $this->belongsTo(Provinsi::class,'provinsi_id','id');
    }
}
