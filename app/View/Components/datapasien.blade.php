<h1>Data Pasien</h1>

<table border="1">
@foreach($pasien as $p)
<tr>
    <td>{{ $p->nama_pasien }}</td>
</tr>
@endforeach
</table>