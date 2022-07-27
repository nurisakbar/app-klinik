<table class="table table-bordered" id="datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Indikator</th>
            <th scope="col">Hasil</th>
            <th scope="col">Nilai Normal</th>
            <th scope="col" width="20">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listIndikator as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->indikator->nama_indikator}}</td>
                <td><a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'hasil' > {{$row->hasil}} </a> </td>
                <td> {{$row->indikator->nilai_rujukan}} </td>
                <td>
                    <button class="btn btn-danger btn-sm btn-hapus-indikator" onClick="hapus_indikator({{$row->id}})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')

@endpush
