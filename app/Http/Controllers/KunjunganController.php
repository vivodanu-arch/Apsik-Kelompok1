<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index()
    {
        $query = Kunjungan::query();

        //filter tanggal
        if (request()->has('tanggal')) {
            $query->whereDate('tanggal', request('tanggal'));
        }

        $kunjungans = $query
        ->orderBy('tanggal', 'desc')
        ->orderBy('jam', 'desc')
        ->paginate(10);

        return view('datakunjungan', compact('kunjungans'));
    }
}