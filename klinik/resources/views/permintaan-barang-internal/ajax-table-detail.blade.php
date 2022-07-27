<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Kode Barang</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Jumlah Diminta</th>
            <th scope="col">Jumlah Diterima</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @php $jumlah_diminta=0;$jumlah_diterima=0 @endphp
        @forelse($permintaanBarangDetail as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->barang->kode}}</td>
                <td>{{$row->barang->nama_barang}}</td>
                <td style="text-align:right">{{$row->jumlah_diminta}}</td>
                <td style="text-align:right">{{$row->jumlah_diterima ? $row->jumlah_diterima : '-'}}</td>
                <td>
                    <button class="btn btn-danger btn-hapus-barang" onClick="hapus_barang({{$row->id}})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @php 
            $jumlah_diminta+=$row->jumlah_diminta;
            $jumlah_diterima+=$row->jumlah_diterima; 
        @endphp
        @empty
            <tr>
                <td colspan=6 style="text-align:center">Data kosong</td>
            </tr>
        @endforelse
        <tr>
            <td style="text-align:right" colspan="3">Total</td>
            <td style="text-align:right"> {{$jumlah_diminta}} </td>
            <td style="text-align:right"> {{$jumlah_diterima}} </td>
            <td></td>
        </tr>
    </tbody>
</table>

@push('scripts')

@endpush