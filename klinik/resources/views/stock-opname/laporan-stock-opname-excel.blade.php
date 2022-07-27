<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan Terkecil</th>
            <th>Satuan Terbesar</th>
            <th>Jenis</th>
            <th>Stock Sebelumnya</th>
            <th>Stock Real</th>
            <th>Selisih</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stock_opnames as $stock_opname)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stock_opname->barang->kode }}</td>
            <td>{{ $stock_opname->barang->nama_barang }}</td>
            <td>{{ $stock_opname->barang->jumlah_satuan_terkecil }} {{ $stock_opname->barang->satuanTerkecil->satuan }}</td>
            <td>{{ $stock_opname->barang->jumlah_satuan_terbesar }} {{ $stock_opname->barang->satuanTerbesar->satuan }}</td>
            <td>{{ $stock_opname->barang->jenis_barang }}</td>
            <td>{{ $stock_opname->stock_sebelumnya }}</td>
            <td>{{ $stock_opname->stock_real }}</td>
            <td>{{ $stock_opname->stock_sebelumnya - $stock_opname->stock_real }}</td>
        </tr>
        @endforeach
    </tbody>
</table>