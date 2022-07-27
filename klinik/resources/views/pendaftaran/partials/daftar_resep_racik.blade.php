<table class="table table-bordered">
    <tr>
        <th width="10">No</th>
        <th>Jumlah Kemasan</th>
        <th>Aturan Pakai</th>
        <th>Detail</th>
        <th width="30"></th>
    </tr>
    @if($pendaftaranResepRacik->count() < 1)
    <tr>
        <td colspan="5">Belum Ada Data</td>
    </tr>
    @else
        @foreach($pendaftaranResepRacik->get() as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->jumlah_kemasan}} - {{ $row->satuan->satuan }}</td>
            <td>{{ $row->aturan_pakai}}</td>
            <td>
                {{-- {{ $row->detail}} --}}
                @foreach($row->detail as $item)
                - {{ $item->barang->nama_barang}} x {{ $item->jumlah}}
                @if(count($row->detail)>1)
                <br>
                @endif
                @endforeach
            </td>
            <td><button onClick="hapus_daftar_obat_racik({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
        @endforeach
    @endif
</table>