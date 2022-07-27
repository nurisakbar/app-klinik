<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>CM</th>
            <th>Nama Pasien</th>
            <th>Nama Tindakan</th>
            <th>Total Fee</th>
            <th>Dokter</th>
            <th>Poliklinik</th>
            <th>Perusahaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporanTindakan as $laporan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ tgl_indo(substr($laporan->created_at, 0, 10)) }}</td>
            <td>{{ $laporan->nomor_rekam_medis }}</td>
            <td>{{ $laporan->nama }}</td>
            <td>{{ $laporan->tindakan }}</td>
            <td>{{ convert_rupiah($laporan->tarif_total) }}</td>
            <td>{{ $laporan->dokter }}</td>
            <td>{{ $laporan->poliklinik }}</td>
            <td>{{ $laporan->nama_perusahaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>