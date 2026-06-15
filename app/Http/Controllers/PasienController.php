<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\Diagnosa;
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
        $user   = Auth::user();

        // Dokter: cek pasien ini memang miliknya, kirim kunjungan+diagnosa
        $kunjungans = collect();
        if ($user->role === 'dokter' && $user->dokter) {
            $dokterId = $user->dokter->id;

            // Pastikan pasien ini pernah ke dokter ini
            $adaKunjungan = $pasien->kunjungans()->where('dokter_id', $dokterId)->exists();
            if (!$adaKunjungan) {
                abort(403, 'Anda tidak memiliki akses ke data pasien ini.');
            }

            $kunjungans = $pasien->kunjungans()
                ->with('diagnosa', 'poli')
                ->where('dokter_id', $dokterId)
                ->orderBy('tanggal_kunjungan', 'desc')
                ->get();
        }

        // Kepala RM tidak boleh edit
        if ($user->role === 'kepalarm') {
            abort(403, 'Kepala RM tidak memiliki akses untuk mengedit data pasien.');
        }

        return view('editdatapasien', compact('pasien', 'kunjungans'));
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

    // Dokter: update diagnosa untuk kunjungan tertentu
    public function updateDiagnosa(Request $request, $kunjunganId)
    {
        $user = Auth::user();
        if ($user->role !== 'dokter' || !$user->dokter) {
            abort(403);
        }

        $kunjungan = Kunjungan::where('id', $kunjunganId)
            ->where('dokter_id', $user->dokter->id)
            ->firstOrFail();

        $request->validate([
            'kode_icd'          => 'nullable|string|max:20',
            'diagnosa_utama'    => 'required|string|max:255',
            'diagnosa_sekunder' => 'nullable|string|max:255',
            'catatan'           => 'nullable|string',
        ]);

        Diagnosa::updateOrCreate(
            ['kunjungan_id' => $kunjungan->id],
            [
                'kode_icd'          => $request->kode_icd,
                'diagnosa_utama'    => $request->diagnosa_utama,
                'diagnosa_sekunder' => $request->diagnosa_sekunder,
                'catatan'           => $request->catatan,
            ]
        );

        // Update status kunjungan jadi diperiksa jika masih menunggu
        if ($kunjungan->status === 'menunggu') {
            $kunjungan->update(['status' => 'diperiksa']);
        }

        return redirect()
            ->route('pasien.edit', $kunjungan->pasien_id)
            ->with('success', 'Diagnosa kunjungan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pasien::findOrFail($id)->delete();
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus');
    }
}