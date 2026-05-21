<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index()
    {
        $query = Kunjungan::with(['pasien', 'dokter', 'diagnosa']);

        // filter tanggal
        if (request()->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', request('tanggal'));
        }

        $kunjungans = $query->orderBy('tanggal_kunjungan', 'desc')
                            ->paginate(10);

        return view('datakunjungan', compact('kunjungans'));
    }
}