<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $query = Pasien::query();

        // Jika dokter: hanya tampilkan pasien yang pernah berkunjung ke dokter ini
        if ($user->role === 'dokter' && $user->dokter) {
            $dokterId = $user->dokter->id;
            $query->whereHas('kunjungans', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            });
        }

        // Search
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                  ->orWhere('no_rm',      'like', "%{$search}%")
                  ->orWhere('telepon',    'like', "%{$search}%");
            });
        }

        $pasien = $query->orderBy('nama_pasien')->paginate(15)->withQueryString();

        return view('datapasien', compact('pasien'));
    }

    public function create()
    {
        return view('createpasien');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rm' => [
                'required',
                'unique:pasiens,no_rm',
                'regex:/^\d{2}-\d{2}-\d{2}$/'
            ],
            'nama_pasien'   => 'required',
            'jenis_kelamin' => 'required',
            'ttl'           => 'required',
            'alamat'        => 'required',
            'telepon'       => 'required',
        ], [
            'no_rm.regex' => 'Format No RM harus 00-00-00',
        ]);

        Pasien::create($request->only([
            'no_rm', 'nama_pasien', 'jenis_kelamin', 'ttl', 'alamat', 'telepon'
        ]));

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('editdatapasien', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_rm' => [
                'required',
                'regex:/^\d{2}-\d{2}-\d{2}$/',
                'unique:pasiens,no_rm,' . $id
            ],
            'nama_pasien'   => 'required',
            'jenis_kelamin' => 'required',
            'ttl'           => 'required',
            'alamat'        => 'required',
            'telepon'       => 'required',
        ], [
            'no_rm.regex' => 'Format No RM harus 00-00-00',
        ]);

        Pasien::findOrFail($id)->update($request->only([
            'no_rm', 'nama_pasien', 'jenis_kelamin', 'ttl', 'alamat', 'telepon'
        ]));

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroy($id)
    {
        Pasien::findOrFail($id)->delete();
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus');
    }
}