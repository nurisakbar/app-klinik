<style>
    * {
        font-size: 7pt;
    }

    table,td, th {
        border: 1px solid black;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
</style>

<center>
    DAFTAR GAJI KARYAWAN KLINIK DR NURDIN WAHID <br>
    PERIODE {{strtoupper($periode)}}
</center>

<hr>

<table>
    <tr>
        <th rowspan= 3 style="width:10px">No</th>
        <th rowspan= 3 >Nama</th>
        <th rowspan= 3>Jabatan</th>
        <th rowspan= 3>Grade</th>
        <th colspan = {{count($tunjangan) + 1}}>Rincian Gaji</th>
        <th colspan = {{count($potongan)}}>Potongan</th>
        <th rowspan = 3>Lembur</th>
        <th rowspan = 3>Total (THP)</th>
    </tr>
    <tr>
        <th rowspan=2>Gaji Pokok</th>
        <th colspan={{count($tunjangan)}}>Tunjangan</th>
        @foreach($potongan as $row)
            <th></th>
        @endforeach
    </tr>
    <tr>
        @foreach($tunjangan as $row)
            <th>{{$row}}</th>
        @endforeach

        @foreach($potongan as $row)
            <th>{{$row}}</th>
        @endforeach
    </tr>
    @forelse($gaji as $row)
    @php
        $total = 0;
        $lembur = 0;
    @endphp
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{ucwords($row->pegawai->nama)}}</td>
        <td>{{ucwords(isset($row->pegawai->kelompok_pegawai) ? $row->pegawai->kelompok_pegawai->nama_kelompok : "Tidak ada jabatan")}}</td>
        <td style="text-align:center">D4</td>
        <td style="text-align:right">{{convert_rupiah($row->pegawai->gaji_pokok)}}</td>
        @php $total += $row->pegawai->gaji_pokok @endphp
        @foreach($tunjangan as $key => $item)
            @php $bonus = 0; @endphp
            @foreach($row->detail as $detailGaji)
                @php
                    if($detailGaji->komponen_gaji_id == $key){
                        $bonus = $detailGaji->jumlah;
                    }
                    if($detailGaji->komponen_gaji->nama_komponen == "Lembur"){
                        $lembur = $detailGaji->jumlah;
                    }
                    $total += $bonus;
                @endphp
            @endforeach
            <td style="text-align:right">{{convert_rupiah($bonus)}}</td>
        @endforeach
        @foreach($potongan as $key => $item)
            @php $potong = 0; @endphp
            @foreach($row->detail as $detailGaji)
                @php
                    if($detailGaji->komponen_gaji_id == $key){
                        $potong = $detailGaji->jumlah;
                    }
                    $total -= $potong;
                @endphp
            @endforeach
            <td style="text-align:right">{{convert_rupiah($potong)}}</td>
        @endforeach
        <td style="text-align:right">{{convert_rupiah($lembur)}}</td>
        @php $total += $lembur @endphp
        <td style="text-align:right">{{convert_rupiah($total)}}</td>
    </tr>
    @empty
        <tr>
            <td colspan=16 style="text-align:center"> Data tidak ditemukan. </td>
        </tr>
    @endforelse
</table>
