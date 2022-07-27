<table class="table table-bordered">
    <tr>
        <th width="10">Nomor Antrian</th>
        <th>Dokter Perujuk</th>
        <th>Nama Unit</th>
        <th>Pemeriksaan</th>
        <th>Status</th>
        <th width="30"></th>
    </tr>
    @if($nomorAntrian->count() < 1)
    <tr>
        <td colspan="5">Belum Ada Data</td>
    </tr>
    @else
        @foreach($nomorAntrian->get() as $row)
        <tr>
            <td>{{ $row->nomor_antrian }}</td>
            <td>{{ $row->dokter->name}}</td>
            <td>{{ $row->poliklinik->nama }}</td>
            <td>
                <?php
                foreach(\App\Models\PendaftaranTindakan::where('pendaftaran_id',$row->pendaftaran->id)->where('poliklinik_id',$row->poliklinik->id)->get() as $tindakan){
                    echo "-".$tindakan->tindakan->tindakan;
                    echo "<br>";
                }    
                ?>
            </td>
            <td>{{ $row->status_pelayanan=='selesai_pemeriksaan_medis'?'Sedang proses':$row->status_pelayanan }}</td>
            <td><button onClick="hapus_rujukan({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
        @endforeach
    @endif
</table>