<h1>Data Laporan</h1>

@forelse($laporans as $l)

<p>{{ $l->nama_pasien }}</p>

@empty

<p>Tidak ada data laporan</p>

@endforelse