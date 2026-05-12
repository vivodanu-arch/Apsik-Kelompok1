<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungans';

    protected $fillable = [
        'tanggal',
        'jam',
        'nama_pasien',
        'poli_tujuan',
        'dokter',
        'diagnosa'
    ];
}