<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'jenis_kelamin',
        'ttl',
        'alamat',
        'telepon',
    ];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'pasien_id');
    }
}