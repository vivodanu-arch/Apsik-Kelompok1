<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = Pasien::paginate(10);
        return view('datapasien', compact('pasien'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('createpasien');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        Pasien::create($request->all());

        return redirect()->route('pasien.index');
    }

    // FORM EDIT
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('editdatapasien', compact('pasien'));
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $pasien->update([
            'no_rm' => $request->no_rm,
            'nama_pasien' => $request->nama_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ttl' => $request->ttl,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('pasien.index');
    }

    // HAPUS
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasien.index');
    }
}