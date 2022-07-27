<table class="table table-bordered" id="myTable">
    <thead>
        <tr>
            <th>Nomor Poli</th>
            <th>Nama Poli</th>
            <th>Jumlah Kunjungan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $poli)
        <tr>
            <td>{{ $poli->nomor_poli }}</td>
            <td>{{ $poli->nama}}</td>
            <td>{{ $poli->jumlah_kunjungan??0}}</td>
        </tr>
        @endforeach
    </tbody>
</table>