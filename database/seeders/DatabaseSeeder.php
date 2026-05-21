<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // DATA POOL — semua data realistis dikumpulkan di sini
        // =========================================================

        $namaLaki = [
            'Ahmad Fauzi', 'Budi Santoso', 'Dian Prakoso', 'Eko Wahyudi', 'Fajar Nugroho',
            'Gunawan Hadi', 'Hendra Wijaya', 'Irfan Maulana', 'Joko Susilo', 'Krisna Adi',
            'Lukman Hakim', 'Muhamad Rizki', 'Nanang Setiawan', 'Oki Firmansyah', 'Prayitno Sari',
            'Rudi Hartono', 'Sandi Pratama', 'Taufik Hidayat', 'Umar Saputra', 'Viko Prasetyo',
            'Wahyu Utomo', 'Yoga Dermawan', 'Zulkifli Anwar', 'Agus Purnomo', 'Bambang Irawan',
            'Cahyo Nugroho', 'Dwi Kurniawan', 'Eko Prasetya', 'Feri Hendri', 'Gani Ramadhan',
            'Hadi Wibowo', 'Ivan Satria', 'Jefri Andika', 'Kurniawan Budi', 'Lutfi Hamdani',
            'Miftah Arifin', 'Noval Setiadi', 'Oki Susanto', 'Putra Ramadhan', 'Qodir Salam',
            'Ragil Pamungkas', 'Slamet Riyadi', 'Teguh Prasetyo', 'Udi Santoso', 'Veri Kurnia',
            'Wahid Nurdin', 'Xandy Pratama', 'Yogi Setiawan', 'Zainal Arifin', 'Andi Cahyono',
        ];

        $namaPerempuan = [
            'Aisyah Rahmawati', 'Bunga Lestari', 'Citra Dewi', 'Dewi Anggraini', 'Elisa Putri',
            'Fatimah Azzahra', 'Gita Nuraini', 'Hani Susilowati', 'Indah Permata', 'Julia Kristina',
            'Kartika Sari', 'Laila Nurhayati', 'Mira Susanti', 'Nina Rahayu', 'Okta Wulandari',
            'Putri Handayani', 'Qonita Afifah', 'Ratna Cahyani', 'Siti Fatimah', 'Tuti Alawiyah',
            'Umi Kalsum', 'Vera Nurdiana', 'Wulan Sari', 'Yanti Kurniasih', 'Zahra Amelia',
            'Anita Wijayanti', 'Bella Octavia', 'Cendikia Pratiwi', 'Dina Mardiana', 'Erni Wati',
            'Fitriani Rahayu', 'Gina Melinda', 'Hesti Ratnasari', 'Ika Wahyuningsih', 'Jihan Fauziah',
            'Kiki Andriani', 'Lia Agustina', 'Meilani Suhardi', 'Nurul Hidayah', 'Ovi Ardiani',
            'Paramita Dewi', 'Qurratu Ain', 'Resti Amalia', 'Sri Mulyani', 'Tika Septiani',
            'Ulfah Nabilah', 'Vivi Octaviani', 'Winda Permatasari', 'Yulia Ningrum', 'Zulfah Aini',
        ];

        $kotaAlamat = [
            'Jl. Mawar No. 12, Jember', 'Jl. Melati No. 5, Banyuwangi', 'Jl. Kenanga No. 8, Lumajang',
            'Jl. Anggrek No. 22, Bondowoso', 'Jl. Dahlia No. 3, Situbondo', 'Jl. Flamboyan No. 17, Probolinggo',
            'Jl. Cempaka No. 9, Pasuruan', 'Jl. Teratai No. 14, Malang', 'Jl. Tulip No. 6, Surabaya',
            'Jl. Lavender No. 11, Mojokerto', 'Jl. Asoka No. 25, Kediri', 'Jl. Bougenville No. 4, Blitar',
            'Jl. Seruni No. 19, Jombang', 'Jl. Camellia No. 7, Sidoarjo', 'Jl. Edelweis No. 33, Gresik',
            'Jl. Frangipani No. 2, Lamongan', 'Jl. Gardenia No. 16, Tuban', 'Jl. Helichrysum No. 28, Bojonegoro',
            'Jl. Iris No. 10, Madiun', 'Jl. Jasmine No. 21, Ngawi',
        ];

        // Kode ICD-10 nyata + nama penyakit
        $diagnosaPenyakit = [
            ['kode' => 'J00',  'nama' => 'Nasofaringitis akut (pilek)',             'sekunder' => 'J06.9'],
            ['kode' => 'J06.9','nama' => 'Infeksi saluran napas atas akut',         'sekunder' => 'J00'],
            ['kode' => 'A09',  'nama' => 'Diare dan gastroenteritis',               'sekunder' => 'K59.1'],
            ['kode' => 'I10',  'nama' => 'Hipertensi esensial (primer)',            'sekunder' => 'I11.9'],
            ['kode' => 'E11',  'nama' => 'Diabetes melitus tipe 2',                'sekunder' => 'E78.5'],
            ['kode' => 'K29.7','nama' => 'Gastritis tidak spesifik',               'sekunder' => 'K21.0'],
            ['kode' => 'R50.9','nama' => 'Demam tidak spesifik',                   'sekunder' => 'R51'],
            ['kode' => 'M54.5','nama' => 'Nyeri punggung bawah',                   'sekunder' => 'M54.4'],
            ['kode' => 'J18.9','nama' => 'Pneumonia tidak spesifik',               'sekunder' => 'J22'],
            ['kode' => 'B01',  'nama' => 'Varisela (cacar air)',                   'sekunder' => 'B09'],
            ['kode' => 'A90',  'nama' => 'Demam berdarah dengue (DBD)',            'sekunder' => 'A91'],
            ['kode' => 'N39.0','nama' => 'Infeksi saluran kemih',                  'sekunder' => 'N30.0'],
            ['kode' => 'K04.0','nama' => 'Pulpitis (sakit gigi)',                  'sekunder' => 'K08.8'],
            ['kode' => 'H10.9','nama' => 'Konjungtivitis tidak spesifik',          'sekunder' => 'H10.1'],
            ['kode' => 'L23',  'nama' => 'Dermatitis kontak alergi',               'sekunder' => 'L50.0'],
            ['kode' => 'J45.9','nama' => 'Asma tidak spesifik',                   'sekunder' => 'J44.1'],
            ['kode' => 'G43.9','nama' => 'Migrain tidak spesifik',                'sekunder' => 'R51'],
            ['kode' => 'E78.5','nama' => 'Hiperlipidemia tidak spesifik',          'sekunder' => 'E11'],
            ['kode' => 'K35',  'nama' => 'Apendisitis akut',                      'sekunder' => 'K37'],
            ['kode' => 'B86',  'nama' => 'Skabies',                               'sekunder' => 'L30.9'],
            ['kode' => 'A15',  'nama' => 'Tuberkulosis paru',                     'sekunder' => 'J18.9'],
            ['kode' => 'J03.9','nama' => 'Tonsilitis akut tidak spesifik',        'sekunder' => 'J02.9'],
            ['kode' => 'F41.1','nama' => 'Gangguan ansietas (kecemasan)',          'sekunder' => 'F41.9'],
            ['kode' => 'R05',  'nama' => 'Batuk',                                 'sekunder' => 'J06.9'],
            ['kode' => 'K21.0','nama' => 'Penyakit refluks gastroesofagus (GERD)', 'sekunder' => 'K29.7'],
        ];

        $keluhanUtama = [
            'Demam tinggi sejak 3 hari yang lalu', 'Batuk dan pilek tidak sembuh-sembuh',
            'Nyeri perut bagian bawah', 'Sakit kepala berdenyut', 'Mual dan muntah berulang',
            'Diare lebih dari 5x sehari', 'Sesak napas saat aktivitas', 'Nyeri dada kiri',
            'Pusing berputar (vertigo)', 'Lemas dan tidak nafsu makan', 'Gatal-gatal di seluruh badan',
            'Nyeri sendi lutut', 'Bengkak di kaki', 'Penglihatan kabur mendadak', 'Sulit tidur',
            'Nyeri punggung menjalar ke kaki', 'Batuk berdarah', 'Kencing sakit dan sering',
            'Ruam merah di kulit', 'Telinga berdenging', 'Jantung berdebar-debar',
            'Badan pegal linu', 'Tenggorokan sakit saat menelan', 'Mata merah dan berair',
            'Sakit gigi berlubang', 'Perut kembung setelah makan', 'Mimisan tidak berhenti',
            'Luka tidak kunjung sembuh', 'Keputihan tidak normal', 'Nyeri kepala bagian belakang',
        ];

        $catatanDokter = [
            'Pasien dianjurkan istirahat cukup dan minum air putih minimal 2 liter per hari.',
            'Observasi selama 3 hari, kontrol ulang jika tidak ada perbaikan.',
            'Rujuk ke spesialis jika keluhan berlanjut lebih dari 1 minggu.',
            'Edukasi pola makan sehat dan olahraga rutin.',
            'Minum obat sesuai anjuran, jangan dihentikan sebelum habis.',
            'Pantau tekanan darah secara rutin setiap minggu.',
            'Diet rendah gula dan karbohidrat sederhana dianjurkan.',
            'Hindari makanan pedas dan berlemak.',
            'Kompres hangat pada area yang nyeri.',
            'Pasien diedukasi mengenai higienitas dan mencuci tangan.',
            null, null, null,
        ];

        // Spesialis dokter
        $spesialisData = [
            ['spesialis' => 'Penyakit Dalam',        'sip_prefix' => 'SIP-DP'],
            ['spesialis' => 'Anak',                  'sip_prefix' => 'SIP-AN'],
            ['spesialis' => 'Bedah Umum',            'sip_prefix' => 'SIP-BD'],
            ['spesialis' => 'Kebidanan & Kandungan', 'sip_prefix' => 'SIP-OB'],
            ['spesialis' => 'Saraf',                 'sip_prefix' => 'SIP-SR'],
            ['spesialis' => 'Kulit & Kelamin',       'sip_prefix' => 'SIP-KK'],
            ['spesialis' => 'Mata',                  'sip_prefix' => 'SIP-MT'],
            ['spesialis' => 'THT',                   'sip_prefix' => 'SIP-TH'],
            ['spesialis' => 'Jantung & Pembuluh',    'sip_prefix' => 'SIP-JP'],
            ['spesialis' => 'Gigi & Mulut',          'sip_prefix' => 'SIP-GM'],
        ];

        // =========================================================
        // 1. AKUN — petugas super-admin, kepalarm, petugas biasa
        // =========================================================
        DB::table('users')->truncate();

        $superAdminId = DB::table('users')->insertGetId([
            'name'              => 'Admin Utama',
            'email'             => 'admin@rs.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'petugas',
            'is_super_admin'    => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('users')->insert([
            'name'              => 'Kepala Rekam Medis',
            'email'             => 'kepalarm@rs.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'kepalarm',
            'is_super_admin'    => false,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('users')->insert([
            'name'              => 'Petugas Registrasi',
            'email'             => 'petugas@rs.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'petugas',
            'is_super_admin'    => false,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // =========================================================
        // 2. DOKTER (10 dokter, masing-masing 1 spesialis/poli)
        // =========================================================
        DB::table('dokters')->truncate();

        $namaDokterLaki = ['dr. Ahmad Rizaldi, Sp.', 'dr. Bambang Nugroho, Sp.', 'dr. Cahyo Wibowo, Sp.', 'dr. Dedy Kurniawan, Sp.', 'dr. Eko Prasetyo, Sp.'];
        $namaDokterPerempuan = ['dr. Farida Hanum, Sp.', 'dr. Gita Rahayu, Sp.', 'dr. Hana Kusuma, Sp.', 'dr. Indah Lestari, Sp.', 'dr. Julia Santoso, Sp.'];
        $namaDokter = array_merge($namaDokterLaki, $namaDokterPerempuan);

        $dokterIds = [];
        foreach ($spesialisData as $i => $sp) {
            $namaLengkap = $namaDokter[$i] . substr($sp['spesialis'], 0, 2);
            $sipNo = $sp['sip_prefix'] . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT) . '/2024';

            $userId = DB::table('users')->insertGetId([
                'name'              => $namaLengkap,
                'email'             => 'dokter' . ($i + 1) . '@rs.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'dokter',
                'is_super_admin'    => false,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            $dokterId = DB::table('dokters')->insertGetId([
                'user_id'    => $userId,
                'nama_dokter'=> $namaLengkap,
                'sip'        => $sipNo,
                'spesialis'  => $sp['spesialis'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $dokterIds[] = ['id' => $dokterId, 'spesialis' => $sp['spesialis']];
        }

        // =========================================================
        // 3. POLI (sesuai spesialis dokter)
        // =========================================================
        DB::table('polis')->truncate();

        $poliData = [
            ['nama_poli' => 'Poli Penyakit Dalam',        'kode_poli' => 'PD',  'deskripsi' => 'Melayani penyakit internal seperti hipertensi, diabetes, dan GERD.', 'lantai' => 'Lantai 1'],
            ['nama_poli' => 'Poli Anak',                  'kode_poli' => 'AN',  'deskripsi' => 'Melayani pasien anak usia 0–18 tahun.', 'lantai' => 'Lantai 1'],
            ['nama_poli' => 'Poli Bedah Umum',            'kode_poli' => 'BD',  'deskripsi' => 'Melayani tindakan bedah elektif dan darurat.', 'lantai' => 'Lantai 2'],
            ['nama_poli' => 'Poli Kebidanan & Kandungan', 'kode_poli' => 'OB',  'deskripsi' => 'Melayani pemeriksaan kehamilan dan kesehatan reproduksi wanita.', 'lantai' => 'Lantai 2'],
            ['nama_poli' => 'Poli Saraf',                 'kode_poli' => 'SR',  'deskripsi' => 'Melayani gangguan sistem saraf pusat dan perifer.', 'lantai' => 'Lantai 3'],
            ['nama_poli' => 'Poli Kulit & Kelamin',       'kode_poli' => 'KK',  'deskripsi' => 'Melayani penyakit kulit, alergi, dan kelamin.', 'lantai' => 'Lantai 1'],
            ['nama_poli' => 'Poli Mata',                  'kode_poli' => 'MT',  'deskripsi' => 'Melayani gangguan penglihatan dan penyakit mata.', 'lantai' => 'Lantai 2'],
            ['nama_poli' => 'Poli THT',                   'kode_poli' => 'TH',  'deskripsi' => 'Melayani gangguan telinga, hidung, dan tenggorokan.', 'lantai' => 'Lantai 2'],
            ['nama_poli' => 'Poli Jantung',               'kode_poli' => 'JP',  'deskripsi' => 'Melayani penyakit jantung dan pembuluh darah.', 'lantai' => 'Lantai 3'],
            ['nama_poli' => 'Poli Gigi & Mulut',          'kode_poli' => 'GM',  'deskripsi' => 'Melayani perawatan gigi, mulut, dan jaringan sekitarnya.', 'lantai' => 'Lantai 1'],
        ];

        $poliIds = [];
        foreach ($poliData as $poli) {
            $poliIds[] = DB::table('polis')->insertGetId(array_merge($poli, [
                'aktif'      => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // =========================================================
        // 4. PASIEN (1200 pasien)
        // =========================================================
        DB::table('pasiens')->truncate();

        $pasienIds = [];
        $rmCounter = 1;
        $totalPasien = 1200;

        $pasienBatch = [];
        for ($i = 0; $i < $totalPasien; $i++) {
            $jenisKelamin = ($i % 2 === 0) ? 'L' : 'P';
            $namaPool     = ($jenisKelamin === 'L') ? $namaLaki : $namaPerempuan;
            $nama         = $namaPool[array_rand($namaPool)];
            $suffix       = ($i > 99) ? ' ' . fake()->randomElement(['Jr.', 'II', 'Putra', 'Putri', 'Bin Suyud', 'Binti Wahid', '']) : '';
            $noRm         = str_pad(intdiv($rmCounter, 100), 2, '0', STR_PAD_LEFT) . '-'
                          . str_pad(intdiv($rmCounter % 100, 10), 2, '0', STR_PAD_LEFT) . '-'
                          . str_pad($rmCounter % 10, 2, '0', STR_PAD_LEFT);

            $tglLahir = Carbon::now()
                ->subYears(rand(5, 75))
                ->subDays(rand(0, 365))
                ->format('Y-m-d');

            $pasienBatch[] = [
                'no_rm'         => sprintf('%02d-%02d-%02d', intdiv($rmCounter, 10000), intdiv($rmCounter % 10000, 100), $rmCounter % 100),
                'nama_pasien'   => trim($nama . $suffix),
                'jenis_kelamin' => $jenisKelamin,
                'ttl'           => $tglLahir,
                'alamat'        => $kotaAlamat[array_rand($kotaAlamat)],
                'telepon'       => '08' . rand(10, 99) . rand(10000000, 99999999),
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            $rmCounter++;

            if (count($pasienBatch) === 100) {
                DB::table('pasiens')->insert($pasienBatch);
                $pasienBatch = [];
            }
        }
        if (!empty($pasienBatch)) {
            DB::table('pasiens')->insert($pasienBatch);
        }

        $pasienIds = DB::table('pasiens')->pluck('id')->toArray();

        // =========================================================
        // 5. KUNJUNGAN + DIAGNOSA (1500 kunjungan, ~12 bulan terakhir)
        // =========================================================
        DB::table('diagnosas')->truncate();
        DB::table('kunjungans')->truncate();

        $statusPool   = ['menunggu', 'diperiksa', 'selesai', 'selesai', 'selesai']; // majority selesai
        $totalKunjungan = 1500;

        // Distribusi penyakit: beberapa penyakit sering, sisanya jarang
        // Ini bikin grafik 10 besar terlihat realistis
        $distribusiDiagnosa = [];
        $bobotPenyakit = [80, 70, 65, 60, 55, 50, 45, 40, 35, 30, 20, 15, 12, 10, 8, 7, 6, 5, 4, 3, 3, 2, 2, 1, 1];
        foreach ($diagnosaPenyakit as $idx => $dp) {
            $bobot = $bobotPenyakit[$idx] ?? 1;
            for ($b = 0; $b < $bobot; $b++) {
                $distribusiDiagnosa[] = $idx;
            }
        }

        for ($i = 0; $i < $totalKunjungan; $i++) {
            $pasienId = $pasienIds[array_rand($pasienIds)];
            $dokterIdx = array_rand($dokterIds);
            $dokterId  = $dokterIds[$dokterIdx]['id'];
            $poliId    = $poliIds[$dokterIdx]; // poli sesuai dokter

            $hariAcak = rand(1, 365);
            $tglKunjungan = Carbon::now()->subDays($hariAcak)->format('Y-m-d');

            $status = $statusPool[array_rand($statusPool)];

            $kunjunganId = DB::table('kunjungans')->insertGetId([
                'pasien_id'         => $pasienId,
                'dokter_id'         => $dokterId,
                'poli_id'           => $poliId,
                'tanggal_kunjungan' => $tglKunjungan,
                'keluhan_utama'     => $keluhanUtama[array_rand($keluhanUtama)],
                'status'            => $status,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // Diagnosa hanya untuk kunjungan yang sudah diperiksa/selesai
            if (in_array($status, ['diperiksa', 'selesai'])) {
                $diagIdx    = $distribusiDiagnosa[array_rand($distribusiDiagnosa)];
                $diag       = $diagnosaPenyakit[$diagIdx];
                $catatan    = $catatanDokter[array_rand($catatanDokter)];

                DB::table('diagnosas')->insert([
                    'kunjungan_id'      => $kunjunganId,
                    'kode_icd'          => $diag['kode'],
                    'diagnosa_utama'    => $diag['nama'],
                    'diagnosa_sekunder' => $diag['sekunder'] ?? null,
                    'catatan'           => $catatan,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('   Pasien   : ' . DB::table('pasiens')->count());
        $this->command->info('   Dokter   : ' . DB::table('dokters')->count());
        $this->command->info('   Poli     : ' . DB::table('polis')->count());
        $this->command->info('   Kunjungan: ' . DB::table('kunjungans')->count());
        $this->command->info('   Diagnosa : ' . DB::table('diagnosas')->count());
        $this->command->info('');
        $this->command->info('Akun login:');
        $this->command->info('  Super admin : admin@rs.com      / password');
        $this->command->info('  Kepala RM   : kepalarm@rs.com   / password');
        $this->command->info('  Petugas     : petugas@rs.com    / password');
        $this->command->info('  Dokter      : dokter1@rs.com ... dokter10@rs.com / password');
    }
}