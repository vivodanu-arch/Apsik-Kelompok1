<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'nik',
        'jenis_kelamin',
        'tgl_lahir',
        'diagnosa',
        'alamat'
    ];
}