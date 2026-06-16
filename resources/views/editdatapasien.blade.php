<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6 space-y-5">

            {{-- Notifikasi --}}
            @if(session('success'))
            <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] z-[9999]">
                <div id="successCard" class="bg-white rounded-3xl shadow-xl p-8 w-[400px] max-w-[90%] text-center transition-all duration-300">
                    <div class="mx-auto w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold shadow-md">✓</div>
                    <h2 class="text-3xl font-bold mt-5 text-gray-800">Berhasil</h2>
                    <p class="text-gray-500 mt-2">{{ session('success') }}</p>
                    <div class="mt-6 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progressBar" class="h-full bg-green-500 rounded-full"></div>
                    </div>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('successModal');
                const card  = document.getElementById('successCard');
                card.style.opacity = '0'; card.style.transform = 'translateY(20px)';
                setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; }, 120);
                document.getElementById('progressBar').animate([{width:'100%'},{width:'0%'}],{duration:1500,fill:'forwards'});
                setTimeout(() => {
                    modal.style.transition = 'all .2s ease'; modal.style.opacity = '0';
                    card.style.transform = 'scale(.8)';
                    setTimeout(() => modal.remove(), 400);
                }, 1500);
            });
            </script>
            @endif

            {{-- Notifikasi error --}}
            @if(session('error'))
            <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                {{ session('error') }}
            </div>
            @endif

            {{-- Header --}}
            <div class="rounded-2xl p-7 text-white shadow-sm"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                <h1 class="text-2xl font-bold">Edit Data Pasien</h1>
                <p class="mt-1 text-blue-200 text-sm">
                    No. RM: <span class="font-mono font-semibold">{{ $pasien->no_rm }}</span>
                    &nbsp;·&nbsp; {{ $pasien->nama_pasien }}
                </p>
            </div>

            {{-- ── FORM DATA PASIEN (petugas & dokter) ── --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-1 h-5 bg-blue-600 rounded-full inline-block"></span>
                    Data Identitas Pasien
                </h2>

                <form id="editPasienForm" action="{{ route('pasien.update', $pasien->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">No. RM</label>
                            <input type="text" name="no_rm"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ $pasien->no_rm }}" placeholder="00-00-00">
                            @error('no_rm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Pasien</label>
                            <input type="text" name="nama_pasien"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ $pasien->nama_pasien }}">
                            @error('nama_pasien')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="L" {{ $pasien->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $pasien->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Lahir</label>
                            <input type="date" name="ttl"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ $pasien->ttl }}">
                        </div>

                        <div class="col-span-2">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Alamat</label>
                            <textarea name="alamat" rows="2"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $pasien->alamat }}</textarea>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Telepon</label>
                            <input type="text" name="telepon"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ $pasien->telepon }}">
                        </div>

                    </div>

                    <div class="mt-5 flex gap-3">
                        <button type="button" onclick="openConfirmModal()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('pasien.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>

            {{-- ── SECTION DIAGNOSA — hanya dokter ── --}}
            @if(Auth::user()->role === 'dokter' && $kunjungans->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-1 h-5 bg-green-500 rounded-full inline-block"></span>
                    Riwayat Kunjungan & Diagnosa
                </h2>
                <p class="text-xs text-gray-400 mb-4">Kunjungan pasien ini ke poli Anda. Klik "Edit Diagnosa" untuk mengisi atau mengubah diagnosa.</p>

                <div class="space-y-4">
                @foreach($kunjungans as $k)
                    <div class="border border-gray-200 rounded-xl overflow-hidden">

                        {{-- Header kunjungan --}}
                        <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="text-sm font-semibold text-gray-700">
                                    {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                </div>
                                <span class="text-xs text-gray-400">·</span>
                                <span class="text-xs text-gray-500">{{ $k->poli->nama_poli ?? '-' }}</span>
                            </div>
                            @php
                                $sc = match($k->status) {
                                    'selesai'   => 'bg-green-100 text-green-700',
                                    'diperiksa' => 'bg-blue-100 text-blue-700',
                                    default     => 'bg-yellow-100 text-yellow-700',
                                };
                                $sl = match($k->status) {
                                    'selesai'   => 'Selesai',
                                    'diperiksa' => 'Diperiksa',
                                    default     => 'Menunggu',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc }}">{{ $sl }}</span>
                        </div>

                        <div class="px-4 py-3">
                            {{-- Keluhan --}}
                            <p class="text-xs text-gray-500 mb-3">
                                <span class="font-semibold text-gray-600">Keluhan: </span>{{ $k->keluhan_utama ?? '-' }}
                            </p>

                            {{-- Diagnosa saat ini --}}
                            @if($k->diagnosa)
                            <div class="bg-blue-50 rounded-lg p-3 mb-3 text-xs grid grid-cols-2 gap-x-4 gap-y-1">
                                <div><span class="text-gray-400">Kode ICD:</span> <span class="font-mono font-semibold text-blue-700">{{ $k->diagnosa->kode_icd ?? '-' }}</span></div>
                                <div><span class="text-gray-400">Diagnosa Utama:</span> <span class="font-medium text-gray-800">{{ $k->diagnosa->diagnosa_utama }}</span></div>
                                <div><span class="text-gray-400">Diagnosa Sekunder:</span> <span class="text-gray-600">{{ $k->diagnosa->diagnosa_sekunder ?? '-' }}</span></div>
                                <div class="col-span-2"><span class="text-gray-400">Catatan:</span> <span class="text-gray-600">{{ $k->diagnosa->catatan ?? '-' }}</span></div>
                            </div>
                            @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-2 mb-3 text-xs text-yellow-700">
                                Belum ada diagnosa untuk kunjungan ini.
                            </div>
                            @endif

                            {{-- Toggle form edit diagnosa --}}
                            <button type="button"
                                onclick="toggleDiagnosa({{ $k->id }})"
                                class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span id="toggle-label-{{ $k->id }}">Edit Diagnosa</span>
                            </button>

                            {{-- Form diagnosa (hidden by default) — input ikut disubmit lewat editPasienForm --}}
                            <div id="form-diagnosa-{{ $k->id }}" class="hidden mt-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Kode ICD-10</label>
                                        <input type="text"
                                            class="w-full mt-1 border border-gray-200 bg-gray-100 rounded-lg px-3 py-1.5 text-xs font-mono text-gray-500 cursor-not-allowed"
                                            value="{{ $k->diagnosa->kode_icd ?? '-' }}"
                                            placeholder="Diisi oleh petugas"
                                            readonly disabled>
                                        <p class="text-[10px] text-gray-400 mt-1">Kode ICD hanya dapat diubah oleh petugas.</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Diagnosa Utama <span class="text-red-500">*</span></label>
                                        <input type="text" name="diagnosa_utama[{{ $k->id }}]" form="editPasienForm" required
                                            class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            value="{{ $k->diagnosa->diagnosa_utama ?? '' }}"
                                            placeholder="Nama penyakit / diagnosa">
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Diagnosa Sekunder</label>
                                        <input type="text" name="diagnosa_sekunder[{{ $k->id }}]" form="editPasienForm"
                                            class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            value="{{ $k->diagnosa->diagnosa_sekunder ?? '' }}"
                                            placeholder="Opsional">
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Catatan</label>
                                        <input type="text" name="catatan[{{ $k->id }}]" form="editPasienForm"
                                            class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            value="{{ $k->diagnosa->catatan ?? '' }}"
                                            placeholder="Anjuran / catatan dokter">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            @endif

            {{-- ── SECTION DIAGNOSA / KODE ICD — hanya petugas ── --}}
            @if(Auth::user()->role === 'petugas' && $kunjungans->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-1 h-5 bg-green-500 rounded-full inline-block"></span>
                    Riwayat Kunjungan & Kode ICD
                </h2>
                <p class="text-xs text-gray-400 mb-4">Diagnosa diisi oleh dokter dan tidak dapat diubah. Petugas hanya dapat mengisi/mengubah Kode ICD-10.</p>

                <div class="space-y-4">
                @foreach($kunjungans as $k)
                    <div class="border border-gray-200 rounded-xl overflow-hidden">

                        {{-- Header kunjungan --}}
                        <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="text-sm font-semibold text-gray-700">
                                    {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                </div>
                                <span class="text-xs text-gray-400">·</span>
                                <span class="text-xs text-gray-500">{{ $k->poli->nama_poli ?? '-' }}</span>
                                <span class="text-xs text-gray-400">·</span>
                                <span class="text-xs text-gray-500">{{ $k->dokter->nama_dokter ?? '-' }}</span>
                            </div>
                            @php
                                $sc = match($k->status) {
                                    'selesai'   => 'bg-green-100 text-green-700',
                                    'diperiksa' => 'bg-blue-100 text-blue-700',
                                    default     => 'bg-yellow-100 text-yellow-700',
                                };
                                $sl = match($k->status) {
                                    'selesai'   => 'Selesai',
                                    'diperiksa' => 'Diperiksa',
                                    default     => 'Menunggu',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc }}">{{ $sl }}</span>
                        </div>

                        <div class="px-4 py-3">
                            {{-- Keluhan --}}
                            <p class="text-xs text-gray-500 mb-3">
                                <span class="font-semibold text-gray-600">Keluhan: </span>{{ $k->keluhan_utama ?? '-' }}
                            </p>

                            @if(!$k->diagnosa)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-2 mb-3 text-xs text-yellow-700">
                                Diagnosa belum diisi oleh dokter. Kode ICD belum dapat diisi.
                            </div>
                            @else
                            {{-- Diagnosa saat ini --}}
                            <div class="bg-blue-50 rounded-lg p-3 mb-3 text-xs grid grid-cols-2 gap-x-4 gap-y-1">
                                <div><span class="text-gray-400">Kode ICD:</span> <span class="font-mono font-semibold text-blue-700">{{ $k->diagnosa->kode_icd ?? '-' }}</span></div>
                                <div><span class="text-gray-400">Diagnosa Utama:</span> <span class="font-medium text-gray-800">{{ $k->diagnosa->diagnosa_utama }}</span></div>
                                <div><span class="text-gray-400">Diagnosa Sekunder:</span> <span class="text-gray-600">{{ $k->diagnosa->diagnosa_sekunder ?? '-' }}</span></div>
                                <div class="col-span-2"><span class="text-gray-400">Catatan:</span> <span class="text-gray-600">{{ $k->diagnosa->catatan ?? '-' }}</span></div>
                            </div>

                            {{-- Toggle form edit kode ICD --}}
                            <button type="button"
                                onclick="toggleDiagnosa({{ $k->id }})"
                                class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span id="toggle-label-{{ $k->id }}">Edit Diagnosa</span>
                            </button>

                            {{-- Form edit kode ICD (hidden by default) — input ikut disubmit lewat editPasienForm --}}
                            <div id="form-diagnosa-{{ $k->id }}" class="hidden mt-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Kode ICD-10</label>
                                        <input type="text" name="kode_icd[{{ $k->id }}]" form="editPasienForm"
                                            class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-1.5 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            value="{{ $k->diagnosa->kode_icd ?? '' }}"
                                            placeholder="Contoh: J06.9">
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Diagnosa Utama <span class="text-red-500">*</span></label>
                                        <input type="text"
                                            class="w-full mt-1 border border-gray-200 bg-gray-100 rounded-lg px-3 py-1.5 text-xs text-gray-500 cursor-not-allowed"
                                            value="{{ $k->diagnosa->diagnosa_utama ?? '-' }}"
                                            readonly disabled>
                                        <p class="text-[10px] text-gray-400 mt-1">Diagnosa hanya dapat diubah oleh dokter.</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Diagnosa Sekunder</label>
                                        <input type="text"
                                            class="w-full mt-1 border border-gray-200 bg-gray-100 rounded-lg px-3 py-1.5 text-xs text-gray-500 cursor-not-allowed"
                                            value="{{ $k->diagnosa->diagnosa_sekunder ?? '-' }}"
                                            readonly disabled>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500">Catatan</label>
                                        <input type="text"
                                            class="w-full mt-1 border border-gray-200 bg-gray-100 rounded-lg px-3 py-1.5 text-xs text-gray-500 cursor-not-allowed"
                                            value="{{ $k->diagnosa->catatan ?? '-' }}"
                                            readonly disabled>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            @endif

        </main>
    </div>
</div>

{{-- Modal Konfirmasi Simpan Data Pasien --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-[9999]">
    <div class="bg-white rounded-2xl shadow-xl w-[420px] max-w-[90%] p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Simpan Perubahan?</h3>
                <p class="text-sm text-gray-500">Seluruh perubahan pada form ini akan disimpan.</p>
            </div>
        </div>
        <div class="border-t pt-4 flex justify-end gap-3">
            <button type="button" onclick="closeConfirmModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm">Batal</button>
            <button type="button" onclick="document.getElementById('editPasienForm').submit()"
                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">Ya, Simpan</button>
        </div>
    </div>
</div>

<script>
function openConfirmModal()  { document.getElementById('confirmModal').classList.remove('hidden'); }
function closeConfirmModal() { document.getElementById('confirmModal').classList.add('hidden'); }

function toggleDiagnosa(id) {
    const form  = document.getElementById('form-diagnosa-' + id);
    const label = document.getElementById('toggle-label-' + id);
    const open  = form.classList.toggle('hidden');
    label.textContent = open ? 'Edit Diagnosa' : 'Tutup';
}
</script>
</body>
</html>