<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Akun</th>
            <th>Kredit</th>
            <th>Debet</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1;?>
        @foreach($neraca_saldo as $neraca)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $neraca['kode'] }}</td>
            <td>{{ $neraca['akun'] }}</td>
            <td>{{ convert_rupiah($neraca['kredit']) ?? '-' }}</td>
            <td>{{ convert_rupiah($neraca['debet']) ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>