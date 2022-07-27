<table class="table table-bordered">
    <tr>
        <th width="10">No</th>
        <th width="90">Tanggal</th>
        <th>Catatan</th>
        <th width="30"></th>
    </tr>
    @if($catatanHarian->count() < 1)
    <tr>
        <td colspan="4">Belum Ada Data</td>
    </tr>
    @else
        @foreach($catatanHarian->get() as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->tanggal}}</td>
            <td>{{ $row->catatan }}</td>
            <td><button onClick="hapus_catatan_harian({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
        @endforeach
    @endif
</table>