<table class="table table-striped">
    <tr>
        <th>Nama Barang</th>
        <th>Unit Stock</th>
        <th>Stock Sekarang</th>
        <th>Stock Baru</th>
    </tr>
    @foreach ($barang as $row)
    <tr>
        <td>{{ $row->nama_barang }}</td>
        <td>{{ $row->nama_unit }}</td>
        <td>{{ $row->jumlah_stock }}</td>
        <td></td>
    </tr>
    @endforeach
</table>