<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan Terbesar</th>
            <th>Satuan Terkecil</th>
            <th>Kategori</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $barang)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$barang->kode}}</td>
            <td>{{$barang->nama_barang}}</td>
            <td>{{$barang->jumlah_satuan_terbesar }} {{ $barang->satuanTerbesar->satuan }}</td>
            <td>{{$barang->jumlah_satuan_terkecil }} {{ $barang->satuanTerkecil->satuan }}</td>
            <td>{{$barang->kategori->nama_kategori??''}}</td>
            <td>{{$barang->harga}}</td>
        </tr>
        @endforeach
    </tbody>
</table>