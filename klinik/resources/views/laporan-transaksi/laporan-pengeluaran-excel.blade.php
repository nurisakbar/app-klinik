<table>
    <tr>
        <td>Nomor</td>
        <td>Tanggal</td>
        <td>Pengeluaran</td>
        <td>Jumlah</td>
    </tr>
    <?php
    $total = 0
    ?>
    @foreach($pengeluaran  as $pe)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $pe->tanggal }}</td>
        <td>{{ $pe->keterangan }}</td>
        <td>{{ $pe->jumlah }}</td>
        <?php $total=$total + $pe->jumlah?>
    </tr>
    @endforeach
    <tr>
        <td></td>
        <td colspan="2">Total</td>
        <td>{{ $total }}</td>
    </tr>
</table>