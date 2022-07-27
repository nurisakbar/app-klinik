<table>
    <tr>
        <th>Tanggal</th>
        <th>Nomor Rekamedis</th>
        <th>Nama</th>
        <th>Poliklinik</th>
        <th>Jenis Asuransi</th>
    </tr>
    @foreach($laporan as $row)
        <tr>
            <td>{{ substr($row->created_at,0,10) }}</td>
            <td>{{ $row->nomor_rekam_medis }}</td>
            <td>{{ $row->nama }}</td>
            <td>{{ $row->nama_poliklinik}}</td>
            <td>{{ $row->nama_perusahaan_asuransi }}</td>
        </tr>
    @endforeach
</table>

