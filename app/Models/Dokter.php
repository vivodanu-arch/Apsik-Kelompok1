<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'user_id',
        'nama_dokter',
        'sip',
        'spesialis',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'dokter_id');
    }
}