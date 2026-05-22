<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $fillable = [
        'tanggal_kunjungan',
        'keluhan_utama',
        'status',
        'pasien_id',
        'dokter_id',
        'poli_id',          // ← tambahan
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function diagnosa()
    {
        return $this->hasOne(Diagnosa::class, 'kunjungan_id');
    }

    // ← relasi baru
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}
