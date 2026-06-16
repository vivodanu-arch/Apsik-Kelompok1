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

        // Petugas: tampilkan seluruh riwayat kunjungan+diagnosa pasien (hanya kode ICD yang bisa diubah)
        if ($user->role === 'petugas') {
            $kunjungans = $pasien->kunjungans()
                ->with('diagnosa', 'poli', 'dokter')
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
        $user   = Auth::user();
        $pasien = Pasien::findOrFail($id);

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

        $pasien->update($request->only([
            'no_rm', 'nama_pasien', 'jenis_kelamin', 'ttl', 'alamat', 'telepon'
        ]));

        // Dokter: simpan diagnosa_utama / diagnosa_sekunder / catatan per kunjungan
        if ($user->role === 'dokter' && $user->dokter) {
            $request->validate([
                'diagnosa_utama.*'    => 'required|string|max:255',
                'diagnosa_sekunder.*' => 'nullable|string|max:255',
                'catatan.*'           => 'nullable|string',
            ]);

            foreach ($request->input('diagnosa_utama', []) as $kunjunganId => $diagnosaUtama) {
                $kunjungan = Kunjungan::where('id', $kunjunganId)
                    ->where('dokter_id', $user->dokter->id)
                    ->first();

                if (!$kunjungan) {
                    continue;
                }

                $diagnosa = Diagnosa::firstOrNew(['kunjungan_id' => $kunjungan->id]);
                $diagnosa->kunjungan_id      = $kunjungan->id;
                $diagnosa->diagnosa_utama    = $diagnosaUtama;
                $diagnosa->diagnosa_sekunder = $request->input("diagnosa_sekunder.$kunjunganId");
                $diagnosa->catatan           = $request->input("catatan.$kunjunganId");
                $diagnosa->save();

                if ($kunjungan->status === 'menunggu') {
                    $kunjungan->update(['status' => 'diperiksa']);
                }
            }
        }

        // Petugas: simpan kode ICD per kunjungan
        if ($user->role === 'petugas') {
            $request->validate([
                'kode_icd.*' => 'nullable|string|max:20',
            ]);

            foreach ($request->input('kode_icd', []) as $kunjunganId => $kodeIcd) {
                $kunjungan = Kunjungan::where('id', $kunjunganId)
                    ->where('pasien_id', $pasien->id)
                    ->first();

                if (!$kunjungan || !$kunjungan->diagnosa) {
                    continue;
                }

                $kunjungan->diagnosa->update(['kode_icd' => $kodeIcd]);
            }
        }

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui');
    }

    // Dokter: update diagnosa utama/sekunder/catatan untuk kunjungan tertentu
    // Petugas: update kode ICD saja untuk kunjungan tertentu
    public function updateDiagnosa(Request $request, $kunjunganId)
    {
        $user = Auth::user();

        if ($user->role === 'dokter' && $user->dokter) {
            // Dokter hanya boleh mengubah diagnosa kunjungan miliknya sendiri
            $kunjungan = Kunjungan::where('id', $kunjunganId)
                ->where('dokter_id', $user->dokter->id)
                ->firstOrFail();

            $request->validate([
                'diagnosa_utama'    => 'required|string|max:255',
                'diagnosa_sekunder' => 'nullable|string|max:255',
                'catatan'           => 'nullable|string',
            ]);

            $diagnosa = Diagnosa::firstOrNew(['kunjungan_id' => $kunjungan->id]);
            $diagnosa->diagnosa_utama    = $request->diagnosa_utama;
            $diagnosa->diagnosa_sekunder = $request->diagnosa_sekunder;
            $diagnosa->catatan           = $request->catatan;
            $diagnosa->kunjungan_id      = $kunjungan->id;
            $diagnosa->save();

            // Update status kunjungan jadi diperiksa jika masih menunggu
            if ($kunjungan->status === 'menunggu') {
                $kunjungan->update(['status' => 'diperiksa']);
            }

            return redirect()
                ->route('pasien.edit', $kunjungan->pasien_id)
                ->with('success', 'Diagnosa kunjungan berhasil diperbarui.');
        }

        if ($user->role === 'petugas') {
            $kunjungan = Kunjungan::findOrFail($kunjunganId);

            $request->validate([
                'kode_icd' => 'nullable|string|max:20',
            ]);

            $diagnosa = $kunjungan->diagnosa;
            if (!$diagnosa) {
                return redirect()
                    ->route('pasien.edit', $kunjungan->pasien_id)
                    ->with('error', 'Diagnosa belum diisi oleh dokter, kode ICD belum bisa diubah.');
            }

            $diagnosa->kode_icd = $request->kode_icd;
            $diagnosa->save();

            return redirect()
                ->route('pasien.edit', $kunjungan->pasien_id)
                ->with('success', 'Kode ICD kunjungan berhasil diperbarui.');
        }

        abort(403);
    }

    public function destroy($id)
    {
        Pasien::findOrFail($id)->delete();
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus');
    }
}