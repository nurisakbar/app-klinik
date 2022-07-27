<table>
    <tr>
        <th>Nomor</th>
        <th>Kode ICD</th>
        <th>Nama Tindakan</th>
        <th>Tarif Umum</th>
        <th>Tarif BPJS</th>
        <th>Tarif Perusahaan</th>
        <th>Poliklinik</th>
        <th>Pelayanan</th>
    </tr>
    @foreach($tindakans as $tindakan)
        <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{ $tindakan->icd->code??'-' }}</td>
            <td>{{ $tindakan->tindakan}}</td>
            <td>{{ $tindakan->tarif_umum}}</td>
            <td>{{ $tindakan->tarif_bpjs}}</td>
            <td>{{ $tindakan->tarif_perusahaan}}</td>
            <td>{{ $tindakan->poliklinik->nama }}</td>
            <td>{{ $tindakan->pelayanan}}</td>
        </tr>
    @endforeach
</table>