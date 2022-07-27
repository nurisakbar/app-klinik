<table class="table table-bordered" id="datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Indikator</th>
            <th scope="col">Satuan</th>
            <th scope="col">Nilai Rujukan</th>
            <th scope="col" width="20">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listIndikator as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td><a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'nama_indikator' > {{$row->nama_indikator}} </a> </td>
                <td><a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'satuan' > {{$row->satuan}} </a> </td>
                <td><a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'nilai_rujukan' > {{$row->nilai_rujukan}} </a> </td>
                <td>
                    <button class="btn btn-danger btn-sm btn-hapus-indikator" onClick="hapus_indikator({{$row->id}})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')

@endpush