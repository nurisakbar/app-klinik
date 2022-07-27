<table class="table table-bordered">
    <tr>
        <th>Nomor</th>
        <th>Nomor Pendaftaran</th>
        <th>Tanggal</th>
    </tr>
    @foreach($riwayat as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->pendaftaran->kode }}</td>
            <td>{{ $row->created_at }}</td>
        </tr>
    @endforeach
</table>