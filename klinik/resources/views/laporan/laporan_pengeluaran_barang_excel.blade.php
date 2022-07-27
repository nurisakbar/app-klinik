<table>
    <tr>
        <th>Nomor</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Jumlah Terjual</th>
        <th>Total Modal</th>
        <th>Total Jual</th>
        <th>Total Keuntungan</th>
    </tr>
    @foreach($laporan as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{$row->kode }}</td>
            <td>{{$row->nama_barang }}</td>
            <td>{{$row->jumlah_terjual??0}}</td>
            <td>{{ $row->total_modal}}</td>
            <td>{{ $row->total_jual}}</td>
            <td>{{ $row->untung}}</td>
        </tr>        
    @endforeach
</table>