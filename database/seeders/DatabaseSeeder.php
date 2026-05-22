<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    // ============================================================
    //  DATA POOL — semua data realistis Indonesia
    // ============================================================

    private array $namaLaki = [
        'Ahmad Fauzi', 'Budi Santoso', 'Dian Prakoso', 'Eko Wahyudi', 'Fajar Nugroho',
        'Gunawan Hadi', 'Hendra Wijaya', 'Irfan Maulana', 'Joko Susilo', 'Krisna Adi',
        'Lukman Hakim', 'Muhammad Rizki', 'Nanang Setiawan', 'Oki Firmansyah', 'Prayitno Agus',
        'Rudi Hartono', 'Sandi Pratama', 'Taufik Hidayat', 'Umar Saputra', 'Viko Prasetyo',
        'Wahyu Utomo', 'Yoga Dermawan', 'Zulkifli Anwar', 'Agus Purnomo', 'Bambang Irawan',
        'Cahyo Nugroho', 'Dwi Kurniawan', 'Eko Prasetya', 'Feri Hendri', 'Gani Ramadhan',
        'Hadi Wibowo', 'Ivan Satria', 'Jefri Andika', 'Kurniawan Budi', 'Lutfi Hamdani',
        'Miftah Arifin', 'Noval Setiadi', 'Oki Susanto', 'Putra Ramadhan', 'Ragil Pamungkas',
        'Slamet Riyadi', 'Teguh Prasetyo', 'Udi Santoso', 'Veri Kurnia', 'Wahid Nurdin',
        'Yogi Setiawan', 'Zainal Arifin', 'Andi Cahyono', 'Basuki Rahmat', 'Catur Wibowo',
        'Doni Setiawan', 'Endro Wicaksono', 'Fatkhul Huda', 'Gilang Ramadhan', 'Haris Maulana',
        'Imam Syafi\'i', 'Juniar Prasetyo', 'Kevin Aditya', 'Lanang Wijaya', 'Mukhlis Adi',
        'Nanda Setiawan', 'Oscar Firmansyah', 'Pandu Prasetyo', 'Qori Maulana', 'Rizal Fahmi',
        'Syukur Ilahi', 'Toha Muharrom', 'Ujang Suherman', 'Vino Saputra', 'Wiryawan Adi',
        'Xander Pratama', 'Yudha Kusuma', 'Zaky Mubarak', 'Aryo Bimo', 'Bagas Prasetyo',
        'Cepi Sudrajat', 'Dika Anugrah', 'Elia Tamara', 'Firman Hidayatullah', 'Gugun Gunawan',
        'Hendra Setiabudi', 'Ikbal Maulana', 'Jaka Sampurna', 'Katno Wibowo', 'Laki Pangestu',
        'Maman Suparman', 'Nuri Setiawan', 'Okky Darmawan', 'Pepen Supendi', 'Qosim Anwar',
        'Rendra Kusuma', 'Sariful Islam', 'Togar Manullang', 'Untung Surapati', 'Vivaldi Rambe',
        'Wahyono Sejati', 'Xaverius Budi', 'Yanuar Rasyid', 'Zulfan Harahap', 'Anton Mulyana',
    ];

    private array $namaPerempuan = [
        'Aisyah Rahmawati', 'Bunga Lestari', 'Citra Dewi', 'Dewi Anggraini', 'Elisa Putri',
        'Fatimah Azzahra', 'Gita Nuraini', 'Hani Susilowati', 'Indah Permata', 'Julia Kristina',
        'Kartika Sari', 'Laila Nurhayati', 'Mira Susanti', 'Nina Rahayu', 'Okta Wulandari',
        'Putri Handayani', 'Ratna Cahyani', 'Siti Fatimah', 'Tuti Alawiyah', 'Umi Kalsum',
        'Vera Nurdiana', 'Wulan Sari', 'Yanti Kurniasih', 'Zahra Amelia', 'Anita Wijayanti',
        'Bella Octavia', 'Cendikia Pratiwi', 'Dina Mardiana', 'Erni Wati', 'Fitriani Rahayu',
        'Gina Melinda', 'Hesti Ratnasari', 'Ika Wahyuningsih', 'Jihan Fauziah', 'Kiki Andriani',
        'Lia Agustina', 'Meilani Suhardi', 'Nurul Hidayah', 'Ovi Ardiani', 'Paramita Dewi',
        'Resti Amalia', 'Sri Mulyani', 'Tika Septiani', 'Ulfah Nabilah', 'Vivi Octaviani',
        'Winda Permatasari', 'Yulia Ningrum', 'Zulfah Aini', 'Ayu Puspitasari', 'Bela Nuraeni',
        'Cantika Rahayu', 'Dita Kusumawati', 'Endang Suryani', 'Fitri Yuliani', 'Giska Amandari',
        'Hanum Sabrina', 'Ika Mustika', 'Juwita Sari', 'Khalisa Amalia', 'Lina Susanti',
        'Mutia Rahma', 'Nisa Aulia', 'Olivia Permatasari', 'Prita Dewi', 'Qonita Nazila',
        'Rani Anjani', 'Salsa Nabila', 'Tasya Kirana', 'Ulfa Safitri', 'Vina Salsabila',
        'Windy Rahayu', 'Xena Kusuma', 'Yessy Anggraeni', 'Zahra Fadhilah', 'Annisa Pratiwi',
        'Bella Fitria', 'Cika Rahmadani', 'Dwi Astuti', 'Elvira Santosa', 'Fatma Wulandari',
        'Grace Permata', 'Herlina Wahyuningsih', 'Intan Novitasari', 'Jessie Amalia', 'Keyla Putri',
        'Lolita Prasasti', 'Mega Permata', 'Nadia Nur', 'Okky Faradiba', 'Prilly Rahmawati',
        'Qisty Aulia', 'Rahma Syafitri', 'Sinta Maharani', 'Tiara Ayu', 'Ulya Khoirun',
        'Venny Andriani', 'Widya Kusuma', 'Xanthy Lestari', 'Yunita Sari', 'Zelda Amalia',
    ];

    private array $alamat = [
        'Jl. Mawar No. 12, Jember', 'Jl. Melati No. 5, Banyuwangi', 'Jl. Kenanga No. 8, Lumajang',
        'Jl. Anggrek No. 22, Bondowoso', 'Jl. Dahlia No. 3, Situbondo', 'Jl. Flamboyan No. 17, Probolinggo',
        'Jl. Cempaka No. 9, Pasuruan', 'Jl. Teratai No. 14, Malang', 'Jl. Tulip No. 6, Surabaya',
        'Jl. Lavender No. 11, Mojokerto', 'Jl. Asoka No. 25, Kediri', 'Jl. Bougenville No. 4, Blitar',
        'Jl. Seruni No. 19, Jombang', 'Jl. Camellia No. 7, Sidoarjo', 'Jl. Edelweis No. 33, Gresik',
        'Jl. Frangipani No. 2, Lamongan', 'Jl. Gardenia No. 16, Tuban', 'Jl. Helichrysum No. 28, Bojonegoro',
        'Jl. Iris No. 10, Madiun', 'Jl. Jasmine No. 21, Ngawi', 'Perum. Griya Indah Blok A-3, Jember',
        'Dsn. Kaliwates RT 02/05, Jember', 'Jl. Gajah Mada No. 44, Jember', 'Jl. Basuki Rahmat No. 7, Jember',
        'Perum. Pesona Alam No. 18, Lumajang', 'Jl. Raya Ambulu KM 5, Jember', 'Dsn. Krajan RT 01/02, Banyuwangi',
        'Jl. Veteran No. 9, Bondowoso', 'Jl. Diponegoro No. 31, Situbondo', 'Jl. Soekarno Hatta No. 55, Probolinggo',
    ];

    // ICD-10 nyata — 25 diagnosa dengan bobot kemunculan
    private array $diagnosaPool = [
        // [kode, nama, sekunder, bobot] — bobot = seberapa sering muncul
        ['J06.9', 'Infeksi saluran napas atas akut tidak spesifik', 'J00',   90],
        ['J00',   'Nasofaringitis akut (pilek)',                    'J06.9', 80],
        ['I10',   'Hipertensi esensial (primer)',                   'I11.9', 75],
        ['A09',   'Diare dan gastroenteritis akut',                 'K59.1', 70],
        ['E11.9', 'Diabetes melitus tipe 2 tanpa komplikasi',       'E78.5', 65],
        ['R50.9', 'Demam tidak spesifik',                           'R51',   60],
        ['K29.7', 'Gastritis tidak spesifik',                       'K21.0', 55],
        ['M54.5', 'Nyeri punggung bawah (low back pain)',           'M54.4', 50],
        ['J18.9', 'Pneumonia tidak spesifik',                       'J22',   40],
        ['A90',   'Demam berdarah dengue (DBD)',                    'A91',   38],
        ['N39.0', 'Infeksi saluran kemih (ISK)',                    'N30.0', 35],
        ['J45.9', 'Asma tidak spesifik',                            'J44.1', 30],
        ['L23',   'Dermatitis kontak alergi',                       'L50.0', 28],
        ['B01',   'Varisela (cacar air)',                            'B09',   25],
        ['J03.9', 'Tonsilitis akut tidak spesifik',                 'J02.9', 22],
        ['K21.0', 'GERD (penyakit refluks gastroesofagus)',         'K29.7', 20],
        ['G43.9', 'Migrain tidak spesifik',                         'R51',   18],
        ['E78.5', 'Hiperlipidemia tidak spesifik',                  'E11.9', 16],
        ['H10.9', 'Konjungtivitis tidak spesifik',                  'H10.1', 14],
        ['K04.0', 'Pulpitis gigi',                                  'K08.8', 12],
        ['A15',   'Tuberkulosis paru',                              'J18.9', 10],
        ['B86',   'Skabies',                                        'L30.9',  8],
        ['F41.1', 'Gangguan ansietas umum',                         'F41.9',  6],
        ['K35',   'Apendisitis akut',                               'K37',    4],
        ['R05',   'Batuk',                                          'J06.9',  3],
    ];

    private array $keluhan = [
        'Demam tinggi sejak 3 hari lalu disertai menggigil',
        'Batuk berdahak dan pilek tidak sembuh-sembuh',
        'Nyeri perut bagian bawah sejak kemarin',
        'Sakit kepala berdenyut sisi kiri',
        'Mual muntah berulang sejak pagi',
        'Diare lebih dari 5x sehari, tinja cair',
        'Sesak napas saat aktivitas ringan',
        'Nyeri dada kiri menjalar ke lengan',
        'Pusing berputar (vertigo) saat bangun tidur',
        'Lemas tidak nafsu makan sejak 2 hari',
        'Gatal-gatal seluruh badan setelah makan seafood',
        'Nyeri sendi lutut saat naik tangga',
        'Bengkak di kedua kaki',
        'Penglihatan kabur mendadak sejak semalam',
        'Sulit tidur dan gelisah sudah 1 minggu',
        'Nyeri punggung menjalar ke kaki kanan',
        'Batuk berdarah sejak 3 hari',
        'Kencing sakit dan sering, warna keruh',
        'Ruam merah berair di kulit tangan',
        'Telinga berdenging sejak 2 hari',
        'Jantung berdebar-debar saat istirahat',
        'Badan pegal linu dan demam ringan',
        'Tenggorokan sakit saat menelan',
        'Mata merah dan berair sejak kemarin',
        'Sakit gigi berlubang, nyeri berdenyut',
        'Perut kembung dan begah setelah makan',
        'Mimisan tidak berhenti selama 10 menit',
        'Luka di kaki tidak kunjung sembuh',
        'Nyeri kepala bagian belakang sejak pagi',
        'Sesak napas disertai mengi saat malam hari',
        'Buang air besar berdarah segar',
        'Benjolan di leher sejak 1 bulan lalu',
        'Pinggang sakit setelah angkat berat',
        'Kulit menguning dan gatal-gatal',
        'Sulit menelan makanan padat',
    ];

    private array $catatan = [
        'Anjurkan istirahat cukup dan minum air putih minimal 2 liter per hari.',
        'Kontrol ulang 3 hari lagi jika tidak ada perbaikan.',
        'Rujuk ke spesialis jika keluhan berlanjut lebih dari 1 minggu.',
        'Edukasi pola makan sehat dan olahraga rutin minimal 30 menit per hari.',
        'Minum obat sesuai anjuran, jangan dihentikan sebelum habis.',
        'Pantau tekanan darah secara rutin setiap minggu.',
        'Diet rendah gula dan karbohidrat sederhana sangat dianjurkan.',
        'Hindari makanan pedas, asam, dan berlemak.',
        'Kompres hangat pada area yang nyeri 2x sehari.',
        'Edukasi higienitas: cuci tangan sebelum makan dan setelah dari toilet.',
        'Pasien dianjurkan mengurangi aktivitas berat sementara.',
        'Terapi fisik direkomendasikan untuk pemulihan jangka panjang.',
        null,
        null,
        null,
    ];

    public function run(): void
    {
        $this->command->info('🔄 Memulai seeder...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('diagnosas')->truncate();
        DB::table('kunjungans')->truncate();
        DB::table('pasiens')->truncate();
        DB::table('dokters')->truncate();
        DB::table('polis')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ============================================================
        // 1. USERS — akun sistem
        // ============================================================
        $this->command->info('   [1/5] Membuat akun pengguna...');

        DB::table('users')->insert([
            [
                'name'           => 'Admin Utama',
                'email'          => 'admin@rs.com',
                'email_verified_at' => now(),
                'password'       => Hash::make('password'),
                'role'           => 'petugas',
                'is_super_admin' => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Siti Nurbayani',
                'email'          => 'kepalarm@rs.com',
                'email_verified_at' => now(),
                'password'       => Hash::make('password'),
                'role'           => 'kepalarm',
                'is_super_admin' => false,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Agus Petugas',
                'email'          => 'petugas@rs.com',
                'email_verified_at' => now(),
                'password'       => Hash::make('password'),
                'role'           => 'petugas',
                'is_super_admin' => false,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        // ============================================================
        // 2. DOKTER — 10 dokter (user + tabel dokters sekaligus)
        // ============================================================
        $this->command->info('   [2/5] Membuat data dokter...');

        $dokterMaster = [
            ['nama' => 'dr. Ahmad Rizaldi, Sp.PD',    'email' => 'dokter1@rs.com', 'spesialis' => 'Penyakit Dalam',        'sip' => 'SIP-PD-0001/2023'],
            ['nama' => 'dr. Bambang Nugroho, Sp.A',   'email' => 'dokter2@rs.com', 'spesialis' => 'Anak',                  'sip' => 'SIP-AN-0002/2023'],
            ['nama' => 'dr. Cahyo Wibowo, Sp.B',      'email' => 'dokter3@rs.com', 'spesialis' => 'Bedah Umum',            'sip' => 'SIP-BD-0003/2023'],
            ['nama' => 'dr. Farida Hanum, Sp.OG',     'email' => 'dokter4@rs.com', 'spesialis' => 'Kebidanan & Kandungan', 'sip' => 'SIP-OG-0004/2023'],
            ['nama' => 'dr. Dedy Kurniawan, Sp.S',    'email' => 'dokter5@rs.com', 'spesialis' => 'Saraf',                 'sip' => 'SIP-SR-0005/2023'],
            ['nama' => 'dr. Gita Rahayu, Sp.KK',      'email' => 'dokter6@rs.com', 'spesialis' => 'Kulit & Kelamin',       'sip' => 'SIP-KK-0006/2023'],
            ['nama' => 'dr. Hana Kusuma, Sp.M',       'email' => 'dokter7@rs.com', 'spesialis' => 'Mata',                  'sip' => 'SIP-MT-0007/2023'],
            ['nama' => 'dr. Eko Prasetyo, Sp.THT',    'email' => 'dokter8@rs.com', 'spesialis' => 'THT',                   'sip' => 'SIP-TH-0008/2023'],
            ['nama' => 'dr. Indah Lestari, Sp.JP',    'email' => 'dokter9@rs.com', 'spesialis' => 'Jantung & Pembuluh',    'sip' => 'SIP-JP-0009/2023'],
            ['nama' => 'dr. Julia Santoso, Sp.KG',    'email' => 'dokter10@rs.com','spesialis' => 'Gigi & Mulut',          'sip' => 'SIP-GM-0010/2023'],
        ];

        $dokterIds = [];
        foreach ($dokterMaster as $d) {
            $userId = DB::table('users')->insertGetId([
                'name'           => $d['nama'],
                'email'          => $d['email'],
                'email_verified_at' => now(),
                'password'       => Hash::make('password'),
                'role'           => 'dokter',
                'is_super_admin' => false,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // SYNC: user dokter → tabel dokters
            $dokterIds[] = DB::table('dokters')->insertGetId([
                'user_id'     => $userId,
                'nama_dokter' => $d['nama'],
                'sip'         => $d['sip'],
                'spesialis'   => $d['spesialis'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // ============================================================
        // 3. POLI — 10 poli sesuai spesialis dokter
        // ============================================================
        $this->command->info('   [3/5] Membuat data poli...');

        $poliMaster = [
            ['nama_poli' => 'Poli Penyakit Dalam',        'kode_poli' => 'PD',  'lantai' => 'Lantai 1', 'deskripsi' => 'Menangani penyakit internal: hipertensi, diabetes, gastritis, dan infeksi.'],
            ['nama_poli' => 'Poli Anak',                  'kode_poli' => 'AN',  'lantai' => 'Lantai 1', 'deskripsi' => 'Melayani pasien anak usia 0–18 tahun termasuk tumbuh kembang dan imunisasi.'],
            ['nama_poli' => 'Poli Bedah Umum',            'kode_poli' => 'BD',  'lantai' => 'Lantai 2', 'deskripsi' => 'Tindakan bedah elektif dan darurat, termasuk apendisitis dan hernia.'],
            ['nama_poli' => 'Poli Kebidanan & Kandungan', 'kode_poli' => 'OG',  'lantai' => 'Lantai 2', 'deskripsi' => 'Pemeriksaan kehamilan, persalinan, dan kesehatan reproduksi wanita.'],
            ['nama_poli' => 'Poli Saraf',                 'kode_poli' => 'SR',  'lantai' => 'Lantai 3', 'deskripsi' => 'Gangguan sistem saraf: stroke, migrain, epilepsi, dan vertigo.'],
            ['nama_poli' => 'Poli Kulit & Kelamin',       'kode_poli' => 'KK',  'lantai' => 'Lantai 1', 'deskripsi' => 'Penyakit kulit, alergi dermatologis, dan infeksi kelamin.'],
            ['nama_poli' => 'Poli Mata',                  'kode_poli' => 'MT',  'lantai' => 'Lantai 2', 'deskripsi' => 'Gangguan penglihatan, katarak, konjungtivitis, dan glaukoma.'],
            ['nama_poli' => 'Poli THT',                   'kode_poli' => 'TH',  'lantai' => 'Lantai 2', 'deskripsi' => 'Gangguan telinga, hidung, tenggorokan, dan tonsilitis.'],
            ['nama_poli' => 'Poli Jantung',               'kode_poli' => 'JP',  'lantai' => 'Lantai 3', 'deskripsi' => 'Penyakit jantung koroner, hipertensi berat, dan aritmia.'],
            ['nama_poli' => 'Poli Gigi & Mulut',          'kode_poli' => 'GM',  'lantai' => 'Lantai 1', 'deskripsi' => 'Perawatan gigi berlubang, cabut gigi, dan kesehatan mulut.'],
        ];

        $poliIds = [];
        foreach ($poliMaster as $p) {
            $poliIds[] = DB::table('polis')->insertGetId(array_merge($p, [
                'aktif'      => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ============================================================
        // 4. PASIEN — 1200 pasien
        // ============================================================
        $this->command->info('   [4/5] Membuat 1200 data pasien...');

        $pasienBatch = [];
        for ($i = 1; $i <= 1200; $i++) {
            $isLaki     = ($i % 2 !== 0);
            $namaPool   = $isLaki ? $this->namaLaki : $this->namaPerempuan;
            $namaBase   = $namaPool[$i % count($namaPool)];
            $gender     = $isLaki ? 'L' : 'P';

            // No RM format: RM-YYYY-XXXXX
            $noRm = 'RM-' . date('Y') . '-' . str_pad($i, 5, '0', STR_PAD_LEFT);

            $umur    = rand(2, 80);
            $tglLahir = Carbon::now()
                ->subYears($umur)
                ->subDays(rand(0, 364))
                ->format('Y-m-d');

            $pasienBatch[] = [
                'no_rm'         => $noRm,
                'nama_pasien'   => $namaBase,
                'jenis_kelamin' => $gender,
                'ttl'           => $tglLahir,
                'alamat'        => $this->alamat[$i % count($this->alamat)],
                'telepon'       => '08' . rand(10, 99) . rand(10000000, 99999999),
                'created_at'    => Carbon::now()->subDays(rand(30, 730)),
                'updated_at'    => now(),
            ];

            // Insert per 200 agar tidak overload memori
            if (count($pasienBatch) === 200) {
                DB::table('pasiens')->insert($pasienBatch);
                $pasienBatch = [];
            }
        }
        if (!empty($pasienBatch)) {
            DB::table('pasiens')->insert($pasienBatch);
        }

        $pasienIds = DB::table('pasiens')->pluck('id')->toArray();

        // ============================================================
        // 5. KUNJUNGAN + DIAGNOSA — 1500 kunjungan dalam 12 bulan
        // ============================================================
        $this->command->info('   [5/5] Membuat 1500 kunjungan + diagnosa...');

        // Buat distribusi berbobot untuk diagnosa
        $distribusiDiagnosa = [];
        foreach ($this->diagnosaPool as $diag) {
            for ($b = 0; $b < $diag[3]; $b++) {
                $distribusiDiagnosa[] = $diag;
            }
        }
        shuffle($distribusiDiagnosa);

        $statusPool = [
            'menunggu'  => 10,  // 10%
            'diperiksa' => 20,  // 20%
            'selesai'   => 70,  // 70%
        ];
        $statusDistribusi = [];
        foreach ($statusPool as $status => $persen) {
            for ($p = 0; $p < $persen; $p++) {
                $statusDistribusi[] = $status;
            }
        }

        $kunjunganBatch = [];
        $diagnosaData   = [];

        for ($i = 0; $i < 1500; $i++) {
            $pasienId  = $pasienIds[array_rand($pasienIds)];
            $dokterIdx = $i % 10; // distribusi merata ke 10 dokter
            if ($i % 30 === 0) $dokterIdx = rand(0, 9); // kadang acak
            $dokterId  = $dokterIds[$dokterIdx];
            $poliId    = $poliIds[$dokterIdx];

            // Distribusi tanggal: lebih banyak di 6 bulan terakhir
            $hariAcak      = ($i % 3 === 0) ? rand(1, 180) : rand(1, 365);
            $tglKunjungan  = Carbon::now()->subDays($hariAcak)->format('Y-m-d');
            $status        = $statusDistribusi[array_rand($statusDistribusi)];

            $kunjunganBatch[] = [
                'pasien_id'         => $pasienId,
                'dokter_id'         => $dokterId,
                'poli_id'           => $poliId,
                'tanggal_kunjungan' => $tglKunjungan,
                'keluhan_utama'     => $this->keluhan[$i % count($this->keluhan)],
                'status'            => $status,
                'created_at'        => $tglKunjungan,
                'updated_at'        => $tglKunjungan,
            ];

            if (count($kunjunganBatch) === 100) {
                DB::table('kunjungans')->insert($kunjunganBatch);
                $kunjunganBatch = [];
            }
        }
        if (!empty($kunjunganBatch)) {
            DB::table('kunjungans')->insert($kunjunganBatch);
        }

        // Insert diagnosa untuk kunjungan yang diperiksa/selesai
        $kunjunganYangDiagnosa = DB::table('kunjungans')
            ->whereIn('status', ['diperiksa', 'selesai'])
            ->pluck('id')
            ->toArray();

        $diagnosaInsert = [];
        foreach ($kunjunganYangDiagnosa as $idx => $kunjunganId) {
            $diag = $distribusiDiagnosa[$idx % count($distribusiDiagnosa)];
            $catatan = $this->catatan[$idx % count($this->catatan)];

            $diagnosaInsert[] = [
                'kunjungan_id'      => $kunjunganId,
                'kode_icd'          => $diag[0],
                'diagnosa_utama'    => $diag[1],
                'diagnosa_sekunder' => $diag[2] ?? null,
                'catatan'           => $catatan,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            if (count($diagnosaInsert) === 100) {
                DB::table('diagnosas')->insert($diagnosaInsert);
                $diagnosaInsert = [];
            }
        }
        if (!empty($diagnosaInsert)) {
            DB::table('diagnosas')->insert($diagnosaInsert);
        }

        // ============================================================
        // RINGKASAN
        // ============================================================
        $this->command->info('');
        $this->command->info('✅ Seeder selesai! Ringkasan data:');
        $this->command->table(
            ['Tabel', 'Jumlah Data'],
            [
                ['users',      DB::table('users')->count()],
                ['dokters',    DB::table('dokters')->count()],
                ['polis',      DB::table('polis')->count()],
                ['pasiens',    DB::table('pasiens')->count()],
                ['kunjungans', DB::table('kunjungans')->count()],
                ['diagnosas',  DB::table('diagnosas')->count()],
            ]
        );
        $this->command->info('');
        $this->command->info('🔐 Akun Login (semua password: "password"):');
        $this->command->info('   Super Admin : admin@rs.com');
        $this->command->info('   Kepala RM   : kepalarm@rs.com');
        $this->command->info('   Petugas     : petugas@rs.com');
        $this->command->info('   Dokter 1-10 : dokter1@rs.com s/d dokter10@rs.com');
    }
}