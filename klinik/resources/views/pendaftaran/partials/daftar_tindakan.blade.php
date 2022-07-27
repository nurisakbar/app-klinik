<table class="table table-bordered">
    <tr>
        <th width="10">No</th>
        {{-- <th width="90">Kode ICD 9</th> --}}
        <th>Nama Tindakan</th>
        <th width="50">Biaya</th>
        <th>Qty</th>
        <th>Diskon</th>
        <th>Subtotal</th>
        <th width="30"></th>
    </tr>
    @if($pendaftaranTindakan->count() < 1)
    <tr>
        <td colspan="4">Belum Ada Data</td>
    </tr>
    @else
        @foreach($pendaftaranTindakan->get() as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->tindakan->tindakan }}<br>
                @foreach(\App\Models\PendaftaranResep::with('barang')->where('tindakan_id',$row->tindakan->id)->where('pendaftaran_id', $nomorAntrian->pendaftaran_id)->where('jenis','bhp')->get() as $bhp)
                <i class="fa fa-trash" onClick="hapus_bhp_tindakan({{$row->tindakan->id}},{{ $bhp->barang_id }},{{ $nomorAntrian->pendaftaran_id}})" aria-hidden="true"></i> {{ $bhp->barang->nama_barang }} x {{ $bhp->jumlah }}<br>
                @endforeach
            </td>
            <td>{{ rupiah($row->fee) }}</td>
            <td>{{ $row->qty }}</td>
            <td>{{ rupiah($row->discount) }}</td>
            <td>{{ rupiah(($row->qty*$row->fee)-$row->discount) }}</td>
            <td>
                <button onClick="hapus_daftar_tindakan({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <button onClick="tambah_bhp({{$row->id}})" style="margin-top:20px;" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalCustomBHP">
                    +
                </button>
            </td>
        </tr>
        @endforeach
    @endif
</table>