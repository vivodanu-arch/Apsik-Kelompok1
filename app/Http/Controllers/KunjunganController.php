<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Poli;
use Illuminate\Support\Facades\Auth;

class KunjunganController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $query = Kunjungan::with(['pasien', 'dokter', 'diagnosa', 'poli']);

        // Jika dokter: hanya kunjungan milik dokter yang login
        if ($user->role === 'dokter' && $user->dokter) {
            $dokterId = $user->dokter->id;
            $query->where('dokter_id', $dokterId);
        }

        // Filter tanggal
        if (request()->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', request('tanggal'));
        }

        // Filter poli (hanya berlaku untuk non-dokter, dokter sudah terkunci ke polinya)
        if (request()->filled('poli_id') && $user->role !== 'dokter') {
            $query->where('poli_id', request('poli_id'));
        }

        // Filter status
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $kunjungans = $query->orderBy('tanggal_kunjungan', 'desc')->paginate(15)->withQueryString();

        // Dropdown poli: dokter hanya lihat polinya, lainnya semua
        if ($user->role === 'dokter' && $user->dokter) {
            $dokterId = $user->dokter->id;
            $poliId   = Kunjungan::where('dokter_id', $dokterId)->value('poli_id');
            $polis    = Poli::where('id', $poliId)->get();
        } else {
            $polis = Poli::orderBy('nama_poli')->get();
        }

        return view('datakunjungan', compact('kunjungans', 'polis'));
    }
}