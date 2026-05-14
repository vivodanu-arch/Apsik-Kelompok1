<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'nama_pasien',
        'tanggal_kunjungan',
        'nama_dokter',
        'nama_poli',
        'no_rm',
        'nik',
        'jenis_kelamin',
        'keluhan_utama',
        'diagnosa_utama',
        'diagnosa_sekunder'
    ];
}