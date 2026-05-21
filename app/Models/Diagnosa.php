<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kunjungan;

class Diagnosa extends Model
{
    protected $fillable = [
        'kunjungan_id',
        'kode_icd',
        'diagnosa_utama',
        'diagnosa_sekunder',
        'catatan',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id');
    }
}