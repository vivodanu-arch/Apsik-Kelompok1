<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = [
        'nama_poli',
        'kode_poli',
        'deskripsi',
        'lantai',
        'aktif',
    ];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'poli_id');
    }
}
