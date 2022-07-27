<table class="table table-bordered" id="datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Kode Barang</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Jumlah Dipakai</th>
            <th>Satuan</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @php $jumlah=0 @endphp
        @foreach($listBhp as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->barang->kode}}</td>
                <td>{{$row->barang->nama_barang}}</td>
                <td style="text-align:right"><input type="text" id="jumlah-{{$row->id}}" value="{{$row->jumlah}}" onKeyUp="ubahJumlah({{$row->id}})" class="form-control"></td>
                <td>{{$row->satuan->satuan??'-'}}</td>
                <td>
                    <button class="btn btn-danger btn-hapus-barang" onClick="hapus_barang({{$row->id}})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @php 
            $jumlah+=$row->jumlah;
        @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align:right">Total</td>
            <td style="text-align:right"> {{$jumlah}} </td>
            <td></td>
        </tr>
    </tfoot>
</table>

@push('scripts')
@endpush