<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Poli;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index()
    {
        // ← tambah 'poli' di eager load, dan filter poli
        $query = Kunjungan::with(['pasien', 'dokter', 'diagnosa', 'poli']);

        if (request()->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', request('tanggal'));
        }

        // filter poli (baru)
        if (request()->filled('poli_id')) {
            $query->where('poli_id', request('poli_id'));
        }

        // filter status (baru)
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $kunjungans = $query->orderBy('tanggal_kunjungan', 'desc')->paginate(15);

        // untuk dropdown filter poli
        $polis = Poli::orderBy('nama_poli')->get();

        return view('datakunjungan', compact('kunjungans', 'polis'));
    }
}
