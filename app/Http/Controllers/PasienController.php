<?php

namespace App\Http\Controllers;

use App\Models\Pasien;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = Pasien::all();
        return view('datapasien', compact('pasien'));
    }
}