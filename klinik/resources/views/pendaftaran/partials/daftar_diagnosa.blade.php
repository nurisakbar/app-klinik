<table class="table table-bordered">
    <tr>
        <th width="10">No</th>
        <th width="90">Kode ICD</th>
        <th>Nama Diagnosa</th>
        <th width="30"></th>
    </tr>
    @if($pendaftaranDiagnosa->count() < 1)
    <tr>
        <td colspan="5">Belum Ada Data</td>
    </tr>
    @else
        @foreach($pendaftaranDiagnosa->get() as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->icd->kode }}</td>
            <td>{{ $row->icd->indonesia }}</td>
            <td><button onClick="hapus_daftar_diagnosa({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
        @endforeach
    @endif
</table>