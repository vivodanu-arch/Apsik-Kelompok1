<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    // ============================================================
    //  NAMA DEPAN & BELAKANG TERPISAH
    //  100 depan × 100 belakang = 10.000 kombinasi → tidak ada duplikat
    // ============================================================

    private array $namaDepanLaki = [
        'Ahmad','Budi','Dian','Eko','Fajar','Gunawan','Hendra','Irfan','Joko','Krisna',
        'Lukman','Muhammad','Nanang','Oki','Prayitno','Rudi','Sandi','Taufik','Umar','Wahyu',
        'Yoga','Zulkifli','Agus','Bambang','Cahyo','Dwi','Feri','Gani','Hadi','Ivan',
        'Jefri','Kurniawan','Lutfi','Miftah','Noval','Putra','Ragil','Slamet','Teguh','Udi',
        'Wahid','Yogi','Zainal','Andi','Basuki','Catur','Doni','Endro','Fatkhul','Gilang',
        'Haris','Imam','Juniar','Kevin','Lanang','Mukhlis','Nanda','Oscar','Pandu','Rizal',
        'Syukur','Toha','Ujang','Vino','Wiryawan','Yudha','Zaky','Aryo','Bagas','Cepi',
        'Dika','Firman','Gugun','Ikbal','Jaka','Katno','Maman','Nuri','Okky','Pepen',
        'Rendra','Sariful','Togar','Untung','Wahyono','Yanuar','Zulfan','Anton','Benny','Chandra',
        'Danang','Erian','Frans','Haryanto','Irwan','Jamal','Khoirul','Luthfi','Marwan','Nugroho',
    ];

    private array $namaBelakangLaki = [
        'Fauzi','Santoso','Prakoso','Wahyudi','Nugroho','Hadi','Wijaya','Maulana','Susilo','Adi',
        'Hakim','Rizki','Setiawan','Firmansyah','Agus','Hartono','Pratama','Hidayat','Saputra','Prasetyo',
        'Utomo','Dermawan','Anwar','Purnomo','Irawan','Kurniawan','Hendri','Ramadhan','Wibowo','Satria',
        'Andika','Budi','Hamdani','Arifin','Setiadi','Pamungkas','Riyadi','Udi','Kurnia','Nurdin',
        'Cahyono','Rahmat','Mubarak','Bimo','Sudrajat','Anugrah','Hidayatullah','Gunawan','Setiabudi','Sampurna',
        'Pangestu','Suparman','Darmawan','Supendi','Kusuma','Islam','Manullang','Surapati','Rambe','Sejati',
        'Mulyana','Siregar','Hasibuan','Nasution','Lubis','Harahap','Matondang','Tampubolon','Gultom','Sihombing',
        'Wardana','Wahyudin','Iskandar','Hermawan','Darmanto','Sudirman','Suprapto','Widodo','Suharto','Mulyono',
        'Prabowo','Handoko','Wicaksono','Sasmito','Purwanto','Hariyanto','Mustofa','Subandi','Triyono','Legowo',
        'Kuswanto','Suyitno','Pamuji','Wahono','Yuwono','Suwito','Budiman','Santosa','Sutrisno','Sugiarto',
    ];

    private array $namaDepanPerempuan = [
        'Aisyah','Bunga','Citra','Dewi','Elisa','Fatimah','Gita','Hani','Indah','Julia',
        'Kartika','Laila','Mira','Nina','Okta','Putri','Ratna','Siti','Tuti','Umi',
        'Vera','Wulan','Yanti','Zahra','Anita','Bella','Cendikia','Dina','Erni','Fitriani',
        'Gina','Hesti','Ika','Jihan','Kiki','Lia','Meilani','Nurul','Ovi','Paramita',
        'Resti','Sri','Tika','Ulfah','Vivi','Winda','Yulia','Zulfah','Ayu','Bela',
        'Cantika','Dita','Endang','Fitri','Giska','Hanum','Intan','Juwita','Khalisa','Lina',
        'Mutia','Nisa','Olivia','Prita','Rani','Salsa','Tasya','Ulfa','Vina','Windy',
        'Yessy','Annisa','Elvira','Fatma','Grace','Herlina','Keyla','Lolita','Mega','Nadia',
        'Prilly','Rahma','Sinta','Tiara','Ulya','Venny','Widya','Yunita','Zelda','Amelia',
        'Bintang','Cahya','Erika','Fanny','Husnul','Isnaini','Khoirun','Melisa','Nela','Opik',
    ];

    private array $namaBelakangPerempuan = [
        'Rahmawati','Lestari','Dewi','Anggraini','Putri','Azzahra','Nuraini','Susilowati','Permata','Kristina',
        'Sari','Nurhayati','Susanti','Rahayu','Wulandari','Handayani','Cahyani','Fatimah','Alawiyah','Kalsum',
        'Nurdiana','Kurniasih','Amelia','Wijayanti','Octavia','Pratiwi','Mardiana','Yuliani','Amandari','Sabrina',
        'Mustika','Agustina','Suhardi','Hidayah','Ardiani','Andriani','Kusumawati','Suryani','Nazila','Anjani',
        'Nabila','Kirana','Safitri','Salsabila','Permatasari','Ningrum','Fadhilah','Nabilah','Aini','Fitria',
        'Rahmadani','Astuti','Wahyuningsih','Novitasari','Maharani','Aulia','Faradiba','Syafitri','Puspitasari','Nuraeni',
        'Kusuma','Oktaviani','Aprilia','Noviani','Indriani','Mulyani','Setiawati','Utami','Pangesti','Pertiwi',
        'Saraswati','Nurhasanah','Islamiyah','Khoiriyah','Rohmah','Hasanah','Fitriyah','Mufidah','Salamah','Kholifah',
        'Zulaikha','Munawaroh','Badriyah','Wafiyah','Latifah','Halimah','Marfuah','Zubaidah','Sundari','Sulastri',
        'Sumarni','Suprapti','Suparni','Sriwati','Sulasih','Sarinem','Suminah','Sumiati','Sutini','Sukini',
    ];

    private array $alamat = [
        'Jl. Mawar No. 12, Jember','Jl. Melati No. 5, Banyuwangi','Jl. Kenanga No. 8, Lumajang',
        'Jl. Anggrek No. 22, Bondowoso','Jl. Dahlia No. 3, Situbondo','Jl. Flamboyan No. 17, Probolinggo',
        'Jl. Cempaka No. 9, Pasuruan','Jl. Teratai No. 14, Malang','Jl. Tulip No. 6, Surabaya',
        'Jl. Lavender No. 11, Mojokerto','Jl. Asoka No. 25, Kediri','Jl. Bougenville No. 4, Blitar',
        'Jl. Seruni No. 19, Jombang','Jl. Camellia No. 7, Sidoarjo','Jl. Edelweis No. 33, Gresik',
        'Jl. Frangipani No. 2, Lamongan','Jl. Gardenia No. 16, Tuban','Jl. Iris No. 10, Madiun',
        'Perum. Griya Indah Blok A-3, Jember','Dsn. Kaliwates RT 02/05, Jember',
        'Jl. Gajah Mada No. 44, Jember','Jl. Basuki Rahmat No. 7, Jember',
        'Perum. Pesona Alam No. 18, Lumajang','Jl. Raya Ambulu KM 5, Jember',
        'Dsn. Krajan RT 01/02, Banyuwangi','Jl. Veteran No. 9, Bondowoso',
        'Jl. Diponegoro No. 31, Situbondo','Jl. Soekarno Hatta No. 55, Probolinggo',
        'Jl. Pahlawan No. 12, Pasuruan','Jl. Merdeka No. 8, Lumajang',
    ];

    private array $diagnosaPool = [
        ['J06.9','Infeksi saluran napas atas akut tidak spesifik','J00',   90],
        ['J00',  'Nasofaringitis akut (pilek)',                   'J06.9', 80],
        ['I10',  'Hipertensi esensial (primer)',                  'I11.9', 75],
        ['A09',  'Diare dan gastroenteritis akut',                'K59.1', 70],
        ['E11.9','Diabetes melitus tipe 2 tanpa komplikasi',      'E78.5', 65],
        ['R50.9','Demam tidak spesifik',                          'R51',   60],
        ['K29.7','Gastritis tidak spesifik',                      'K21.0', 55],
        ['M54.5','Nyeri punggung bawah (low back pain)',          'M54.4', 50],
        ['J18.9','Pneumonia tidak spesifik',                      'J22',   40],
        ['A90',  'Demam berdarah dengue (DBD)',                   'A91',   38],
        ['N39.0','Infeksi saluran kemih (ISK)',                   'N30.0', 35],
        ['J45.9','Asma tidak spesifik',                           'J44.1', 30],
        ['L23',  'Dermatitis kontak alergi',                      'L50.0', 28],
        ['B01',  'Varisela (cacar air)',                           'B09',   25],
        ['J03.9','Tonsilitis akut tidak spesifik',                'J02.9', 22],
        ['K21.0','GERD (penyakit refluks gastroesofagus)',        'K29.7', 20],
        ['G43.9','Migrain tidak spesifik',                        'R51',   18],
        ['E78.5','Hiperlipidemia tidak spesifik',                 'E11.9', 16],
        ['H10.9','Konjungtivitis tidak spesifik',                 'H10.1', 14],
        ['K04.0','Pulpitis gigi',                                 'K08.8', 12],
        ['A15',  'Tuberkulosis paru',                             'J18.9', 10],
        ['B86',  'Skabies',                                       'L30.9',  8],
        ['F41.1','Gangguan ansietas umum',                        'F41.9',  6],
        ['K35',  'Apendisitis akut',                              'K37',    4],
        ['R05',  'Batuk',                                         'J06.9',  3],
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
        null, null, null,
    ];

    // ─── Helper: nama unik dari kombinasi depan + belakang ─────────────
    private function namaUnik(int $index, string $gender): string
    {
        $depan    = $gender === 'L' ? $this->namaDepanLaki    : $this->namaDepanPerempuan;
        $belakang = $gender === 'L' ? $this->namaBelakangLaki : $this->namaBelakangPerempuan;

        $cd = count($depan);
        $cb = count($belakang);

        $iDepan    = $index % $cd;
        $iBelakang = (int) floor($index / $cd) % $cb;
        $putaran   = (int) floor($index / ($cd * $cb));
        $suffix    = $putaran > 0 ? ' ' . ($putaran + 1) : '';

        return $depan[$iDepan] . ' ' . $belakang[$iBelakang] . $suffix;
    }

    // ─── Helper: format No RM → 00-00-00 ───────────────────────────────
    private function formatNoRm(int $nomor): string
    {
        // Nomor 1–999999 → dua digit per segmen, contoh: 000001 → 00-00-01
        $padded = str_pad($nomor, 6, '0', STR_PAD_LEFT); // "000042"
        return substr($padded, 0, 2) . '-' . substr($padded, 2, 2) . '-' . substr($padded, 4, 2);
        // "00-00-42"
    }

    // ============================================================
    //  MAIN
    // ============================================================
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

        // ── 1. USERS ──────────────────────────────────────────────────
        $this->command->info('   [1/5] Akun pengguna...');
        DB::table('users')->insert([
            ['name'=>'Admin Utama',    'email'=>'admin@rs.com',    'email_verified_at'=>now(),'password'=>Hash::make('password'),'role'=>'petugas', 'is_super_admin'=>true, 'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Siti Nurbayani', 'email'=>'kepalarm@rs.com', 'email_verified_at'=>now(),'password'=>Hash::make('password'),'role'=>'kepalarm','is_super_admin'=>false,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Agus Petugas',   'email'=>'petugas@rs.com',  'email_verified_at'=>now(),'password'=>Hash::make('password'),'role'=>'petugas', 'is_super_admin'=>false,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── 2. DOKTER ─────────────────────────────────────────────────
        $this->command->info('   [2/5] Data dokter...');
        $dokterMaster = [
            ['nama'=>'dr. Ahmad Rizaldi, Sp.PD', 'email'=>'dokter1@rs.com', 'spesialis'=>'Penyakit Dalam',        'sip'=>'SIP-PD-0001/2023'],
            ['nama'=>'dr. Bambang Nugroho, Sp.A', 'email'=>'dokter2@rs.com','spesialis'=>'Anak',                  'sip'=>'SIP-AN-0002/2023'],
            ['nama'=>'dr. Cahyo Wibowo, Sp.B',    'email'=>'dokter3@rs.com','spesialis'=>'Bedah Umum',            'sip'=>'SIP-BD-0003/2023'],
            ['nama'=>'dr. Farida Hanum, Sp.OG',   'email'=>'dokter4@rs.com','spesialis'=>'Kebidanan & Kandungan', 'sip'=>'SIP-OG-0004/2023'],
            ['nama'=>'dr. Dedy Kurniawan, Sp.S',  'email'=>'dokter5@rs.com','spesialis'=>'Saraf',                 'sip'=>'SIP-SR-0005/2023'],
            ['nama'=>'dr. Gita Rahayu, Sp.KK',    'email'=>'dokter6@rs.com','spesialis'=>'Kulit & Kelamin',       'sip'=>'SIP-KK-0006/2023'],
            ['nama'=>'dr. Hana Kusuma, Sp.M',      'email'=>'dokter7@rs.com','spesialis'=>'Mata',                  'sip'=>'SIP-MT-0007/2023'],
            ['nama'=>'dr. Eko Prasetyo, Sp.THT',  'email'=>'dokter8@rs.com','spesialis'=>'THT',                   'sip'=>'SIP-TH-0008/2023'],
            ['nama'=>'dr. Indah Lestari, Sp.JP',  'email'=>'dokter9@rs.com','spesialis'=>'Jantung & Pembuluh',    'sip'=>'SIP-JP-0009/2023'],
            ['nama'=>'dr. Julia Santoso, Sp.KG',  'email'=>'dokter10@rs.com','spesialis'=>'Gigi & Mulut',         'sip'=>'SIP-GM-0010/2023'],
        ];
        $dokterIds = [];
        foreach ($dokterMaster as $d) {
            $uid = DB::table('users')->insertGetId([
                'name'=>$d['nama'],'email'=>$d['email'],'email_verified_at'=>now(),
                'password'=>Hash::make('password'),'role'=>'dokter','is_super_admin'=>false,
                'created_at'=>now(),'updated_at'=>now(),
            ]);
            $dokterIds[] = DB::table('dokters')->insertGetId([
                'user_id'=>$uid,'nama_dokter'=>$d['nama'],'sip'=>$d['sip'],
                'spesialis'=>$d['spesialis'],'created_at'=>now(),'updated_at'=>now(),
            ]);
        }

        // ── 3. POLI ───────────────────────────────────────────────────
        $this->command->info('   [3/5] Data poli...');
        $poliMaster = [
            ['nama_poli'=>'Poli Penyakit Dalam',        'kode_poli'=>'PD','lantai'=>'Lantai 1','deskripsi'=>'Menangani penyakit internal: hipertensi, diabetes, gastritis, dan infeksi.'],
            ['nama_poli'=>'Poli Anak',                  'kode_poli'=>'AN','lantai'=>'Lantai 1','deskripsi'=>'Melayani pasien anak usia 0–18 tahun termasuk tumbuh kembang dan imunisasi.'],
            ['nama_poli'=>'Poli Bedah Umum',            'kode_poli'=>'BD','lantai'=>'Lantai 2','deskripsi'=>'Tindakan bedah elektif dan darurat, termasuk apendisitis dan hernia.'],
            ['nama_poli'=>'Poli Kebidanan & Kandungan', 'kode_poli'=>'OG','lantai'=>'Lantai 2','deskripsi'=>'Pemeriksaan kehamilan, persalinan, dan kesehatan reproduksi wanita.'],
            ['nama_poli'=>'Poli Saraf',                 'kode_poli'=>'SR','lantai'=>'Lantai 3','deskripsi'=>'Gangguan sistem saraf: stroke, migrain, epilepsi, dan vertigo.'],
            ['nama_poli'=>'Poli Kulit & Kelamin',       'kode_poli'=>'KK','lantai'=>'Lantai 1','deskripsi'=>'Penyakit kulit, alergi dermatologis, dan infeksi kelamin.'],
            ['nama_poli'=>'Poli Mata',                  'kode_poli'=>'MT','lantai'=>'Lantai 2','deskripsi'=>'Gangguan penglihatan, katarak, konjungtivitis, dan glaukoma.'],
            ['nama_poli'=>'Poli THT',                   'kode_poli'=>'TH','lantai'=>'Lantai 2','deskripsi'=>'Gangguan telinga, hidung, tenggorokan, dan tonsilitis.'],
            ['nama_poli'=>'Poli Jantung',               'kode_poli'=>'JP','lantai'=>'Lantai 3','deskripsi'=>'Penyakit jantung koroner, hipertensi berat, dan aritmia.'],
            ['nama_poli'=>'Poli Gigi & Mulut',          'kode_poli'=>'GM','lantai'=>'Lantai 1','deskripsi'=>'Perawatan gigi berlubang, cabut gigi, dan kesehatan mulut.'],
        ];
        $poliIds = [];
        foreach ($poliMaster as $p) {
            $poliIds[] = DB::table('polis')->insertGetId(array_merge($p,['aktif'=>true,'created_at'=>now(),'updated_at'=>now()]));
        }

        // ── 4. PASIEN — 1200, nama unik, No RM format 00-00-00 ────────
        $this->command->info('   [4/5] 1200 data pasien (nama unik, No RM 00-00-00)...');

        $batch = [];
        $ctrL  = 0; // counter laki-laki
        $ctrP  = 0; // counter perempuan

        for ($i = 1; $i <= 1200; $i++) {
            $isLaki = ($i % 2 !== 0);
            $gender = $isLaki ? 'L' : 'P';

            // Nama unik: kombinasi sistematis depan + belakang
            $nama = $isLaki
                ? $this->namaUnik($ctrL++, 'L')
                : $this->namaUnik($ctrP++, 'P');

            // No RM format 00-00-00 (urut, dijamin unik)
            $noRm = $this->formatNoRm($i);

            $batch[] = [
                'no_rm'         => $noRm,
                'nama_pasien'   => $nama,
                'jenis_kelamin' => $gender,
                'ttl'           => Carbon::now()->subYears(rand(2,80))->subDays(rand(0,364))->format('Y-m-d'),
                'alamat'        => $this->alamat[$i % count($this->alamat)],
                'telepon'       => '08'.rand(10,99).rand(10000000,99999999),
                'created_at'    => Carbon::now()->subDays(rand(30,730)),
                'updated_at'    => now(),
            ];

            if (count($batch) === 200) {
                DB::table('pasiens')->insert($batch);
                $batch = [];
            }
        }
        if (!empty($batch)) DB::table('pasiens')->insert($batch);

        $pasienIds = DB::table('pasiens')->pluck('id')->toArray();

        // ── 5. KUNJUNGAN + DIAGNOSA ────────────────────────────────────
        $this->command->info('   [5/5] 1500 kunjungan + diagnosa...');

        // Distribusi berbobot
        $distribusi = [];
        foreach ($this->diagnosaPool as $d) {
            for ($b = 0; $b < $d[3]; $b++) $distribusi[] = $d;
        }
        shuffle($distribusi);

        $statusPool = array_merge(
            array_fill(0,10,'menunggu'),
            array_fill(0,20,'diperiksa'),
            array_fill(0,70,'selesai')
        );

        $kBatch = [];
        for ($i = 0; $i < 1500; $i++) {
            $dokterIdx = ($i % 3 === 0) ? rand(0,9) : ($i % 10);
            $tgl = Carbon::now()->subDays(($i % 3 === 0) ? rand(1,180) : rand(1,365))->format('Y-m-d');
            $kBatch[] = [
                'pasien_id'         => $pasienIds[array_rand($pasienIds)],
                'dokter_id'         => $dokterIds[$dokterIdx],
                'poli_id'           => $poliIds[$dokterIdx],
                'tanggal_kunjungan' => $tgl,
                'keluhan_utama'     => $this->keluhan[$i % count($this->keluhan)],
                'status'            => $statusPool[array_rand($statusPool)],
                'created_at'        => $tgl,
                'updated_at'        => $tgl,
            ];
            if (count($kBatch) === 100) { DB::table('kunjungans')->insert($kBatch); $kBatch = []; }
        }
        if (!empty($kBatch)) DB::table('kunjungans')->insert($kBatch);

        // Diagnosa untuk kunjungan diperiksa/selesai
        $kdIds = DB::table('kunjungans')->whereIn('status',['diperiksa','selesai'])->pluck('id')->toArray();
        $dBatch = [];
        foreach ($kdIds as $idx => $kid) {
            $diag = $distribusi[$idx % count($distribusi)];
            $dBatch[] = [
                'kunjungan_id'      => $kid,
                'kode_icd'          => $diag[0],
                'diagnosa_utama'    => $diag[1],
                'diagnosa_sekunder' => $diag[2] ?? null,
                'catatan'           => $this->catatan[$idx % count($this->catatan)],
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
            if (count($dBatch) === 100) { DB::table('diagnosas')->insert($dBatch); $dBatch = []; }
        }
        if (!empty($dBatch)) DB::table('diagnosas')->insert($dBatch);

        // ── RINGKASAN ─────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('✅ Seeder selesai!');
        $this->command->table(
            ['Tabel','Jumlah'],
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
        $this->command->info('🔐 Login (password: "password")');
        $this->command->info('   admin@rs.com | kepalarm@rs.com | petugas@rs.com');
        $this->command->info('   dokter1@rs.com ... dokter10@rs.com');
        $this->command->info('');
        $this->command->info('📋 Contoh No RM: 00-00-01 s/d 00-12-00');
    }
}
