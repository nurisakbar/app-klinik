<table class="table table-bordered">
    <tr>
        <th width="10">No</th>
        <th>Nama Obat</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
        <th width="100">Harga</th>
        <th width="100">Subtotal</th>
        <th width="30"></th>
    </tr>
    @if($pendaftaranResep->count() < 1)
    <tr>
        <td colspan="5">Belum Ada Data</td>
    </tr>
    @else
        @foreach($pendaftaranResep->get() as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->barang->nama_barang}}</td>
            <td>{{ $row->jumlah .' '.$row->barang->satuanTerkecil->satuan}}</td>
            <td>{{ $row->aturan_pakai }}</td>
            <td>{{ convert_rupiah($row->harga) }}</td>
            <td>{{ convert_rupiah($row->jumlah * $row->harga) }}</td>
            <td><button onClick="hapus_daftar_obat_non_racik({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
        @endforeach
    @endif
</table>