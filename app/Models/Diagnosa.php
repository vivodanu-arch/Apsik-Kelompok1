<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    protected $fillable = [
        'diagnosa_utama'
    ];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'diagnosa_id');
    }
}