<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    // =========================
    // TAMPIL DATA
    // =========================
    public function index()
    {
        $pasien = Pasien::paginate(10);

        return view('datapasien', compact('pasien'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        return view('createpasien');
    }

    // =========================
    // SIMPAN DATA
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'no_rm' => [
                'required',
                'unique:pasiens,no_rm',
                'regex:/^\d{2}-\d{2}-\d{2}$/'
            ],

            'nama_pasien' => 'required',
            'jenis_kelamin' => 'required',
            'ttl' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ], [
            'no_rm.regex' => 'Format No RM harus 00-00-00',
        ]);

        Pasien::create([
            'no_rm' => $request->no_rm,
            'nama_pasien' => $request->nama_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ttl' => $request->ttl,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()
            ->route('pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);

        return view('editdatapasien', compact('pasien'));
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_rm' => [
                'required',
                'regex:/^\d{2}-\d{2}-\d{2}$/',
                'unique:pasiens,no_rm,' . $id
            ],

            'nama_pasien' => 'required',
            'jenis_kelamin' => 'required',
            'ttl' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ], [
            'no_rm.regex' => 'Format No RM harus 00-00-00',
        ]);

        $pasien = Pasien::findOrFail($id);

        $pasien->update([
            'no_rm' => $request->no_rm,
            'nama_pasien' => $request->nama_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ttl' => $request->ttl,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()
            ->route('pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);

        $pasien->delete();

        return redirect()
            ->route('pasien.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }
}