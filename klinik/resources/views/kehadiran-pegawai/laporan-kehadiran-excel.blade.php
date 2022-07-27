<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jadwal Shift</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan_kehadiran as $laporan)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$laporan->nama}}</td>
            <td>{{$laporan->nama_shift}}</td>
            <td>{{$laporan->jam_masuk}}</td>
            <td>{{$laporan->jam_keluar}}</td>
            <td>{{tgl_indo($laporan->tanggal)}}</td>
            <td>{{ $status_kehadiran[$laporan->status] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>