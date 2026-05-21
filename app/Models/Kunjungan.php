<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Diagnosa;

class Kunjungan extends Model
{
    protected $fillable = [
        'tanggal_kunjungan',
        'keluhan_utama',
        'status',
        'pasien_id',
        'dokter_id',
        'diagnosa_id',
    ];

    // RELASI KE PASIEN
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // RELASI KE DOKTER
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    // RELASI KE DIAGNOSA
    public function diagnosa()
    {
        return $this->belongsTo(Diagnosa::class, 'diagnosa_id');
    }
}