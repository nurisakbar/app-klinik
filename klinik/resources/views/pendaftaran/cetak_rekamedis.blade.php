<style>
    body{
        font-size: 13px;
    }
    .table, .td, .th {
    border: 1px solid;
    text-align: left;
    padding:5px;
    }

    .table {
    width: 100%;
    border-collapse: collapse;
}
</style>

<div>
    <table>
        <tr>
            <td><img src="https://alumniphb.net/upload/loker//download_(3)1.png" alt=""></td>
            <td>
                <h3>KLINIK DR. NURDIN WAHID</h3>
                <p style="margin: -13px 0">Jl. HM. Ashari no.22 Cibinong-Bogor</p>
                <p>Telp. 021 87916739</p>
            </td>
        </tr>
    </table>
</div>
<hr>


<table>
    <tr>
        <td width="100">Nama Pasien</td>
        <td> : {{ $pendaftaran->pasien->nama }}</td>
        <td>TGL / Jam Kunjungan</td>
        <td> : {{ tgl_indo(substr($pendaftaran->created_at,0,10)) }} /  {{ substr($pendaftaran->created_at,11,5)}} </td>
    </tr>
    <tr>
        <td width="80">No RM</td>
        <td width="150"> : {{ $pendaftaran->pasien->nomor_rekam_medis}}</td>
        <td width="80">Nomor Kartu</td>
        <td width="150"> : {{ $pendaftaran->pasien->nik }}</td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td> : {{ $pendaftaran->pasien->tempat_lahir.', '. tgl_indo($pendaftaran->pasien->tanggal_lahir) }}</td>
        <td>NIK</td>
        <td> : {{ ucfirst($pendaftaran->pasien->nomor_ktp) }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td> : {{ $pendaftaran->pasien->alamat }}</td>
        <td>Peserta</td>
        <td> : -</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td> : {{ ucfirst($pendaftaran->pasien->jenis_kelamin) }}</td>
        <td>Perusahaan</td>
        <td> : {{ $pendaftaran->perusahaanAsuransi->nama_perusahaan }}</td>
    </tr>
    <tr>
        <td>AO</td>
        <td> : </td>
        <td>Ibu Kandung</td>
        <td> : {{ ucfirst($pendaftaran->pasien->nama_ibu) }}</td>
    </tr>
</table>

<br><br>

<table class="table">
    <tr valign="top">
        <td class="td">Riwayat Penyakit</td>
        <td class="td">
            @foreach($riwayatPenyakit as $rwp)
                - {{ $rwp->tbmIcd->indonesia}}<br>
            @endforeach
        </td>
    </tr>
    <tr>
        <td class="td">Riwayat Alergi</td>
        <td class="td"></td>
    </tr>
    <tr valign="top">
        <td class="td">Pemeriksaan TTV</td>
        <td class="td">
            1 - Kesadaran : {{ $nomorAntrian->pendaftaran->tanda_tanda_vital['kesadaran']??0 }} mmHg<br>
            2 - TD : {{ $nomorAntrian->pendaftaran->tanda_tanda_vital['tekanan_darah'] }} x/Menit<br>
            3 - Nadi : {{ $nomorAntrian->pendaftaran->tanda_tanda_vital['nadi'] }} Kg<br>
            4 - RR : {{ $nomorAntrian->pendaftaran->tanda_tanda_vital['rr'] }} mmHg<br>
            5 - SP02 : {{ $nomorAntrian->pendaftaran->tanda_tanda_vital['saturasi_o2'] }} mmHg<br>
            6 - Suhu  :{{ $nomorAntrian->pendaftaran->tanda_tanda_vital['suhu_tubuh'] }}<br>
            7 - Lain Lain : {{ $nomorAntrian->lain_lain }}
        </td>
    </tr>
    <tr>
        <td class="td">Anamnesa</td>
        <td class="td">{{ $nomorAntrian->pendaftaran->anamnesa==null?$nomorAntrian->anamnesa:$nomorAntrian->pendaftaran->anamnesa }}</td>
    </tr>
    <tr valign="top">
        <td class="td">Pemeriksaan Fisik</td>
        <td class="td">
            @foreach($pendaftaran->pemeriksaan_klinis as $keyPm => $valPm)
                @if($valPm!==null)
                - {{  str_replace('"','',$keyPm)}} : {{ $valPm}} <br>
                @endif
            @endforeach
        </td>
    </tr>
    <tr>
        <td class="td">Diagnosa</td>
        <td class="td">
            @foreach($pendaftaranDiagnosa as $pd)
                - {{ $pd->icd->indonesia }}<br>
            @endforeach
        </td>
    </tr>
    <tr valign="top">
        <td class="td">Tindakan</td>
        <td class="td">
            @foreach($pendaftaranTindakan as $t)
                - {{ $t->tindakan->tindakan }}<br>
            @endforeach
        </td>
    </tr>
    <tr>
        <td class="td">Laboratorium</td>
        <td class="td">
            -
        </td>
    </tr>
    <tr>
        <td class="td">Terapi Obat</td>
        <td class="td">
            @foreach($pendaftaranResep as $pr)
                - {{ $pr->barang->nama_barang }} {{ $pr->barang->satuanTerkecil->satuan}} @ {{ $pr->jumlah }} | {{ $pr->aturan_pakai }}<br>
            @endforeach
        </td>
    </tr>
    <tr>
        <td class="td">Keterangan</td>
        <td class="td">
            - Surat Sakit/ Sehat<br>
            - Surat Rujukan<br>
            - Lain nya :  ................................
        </td>
    </tr>
</table>


<div class="ttd" style="margin-left:550px;margin-top:50px;font-weight:bold;text-align:center">
<p>Tanda tangan</p>

<p style="margin-top:100px;">{{ $nomorAntrian->dokter->name }}</p>
</div>



{{-- <table class="table">
    <tr>
        <th class="th">Tanggal</th>
        <th class="th">Anamnesa</th>
        <th class="th">Diagnosa</th>
        <th class="th">Keterangan</th>
    </tr>
    @foreach($riwayatKunjungan as $riwayat)
    <tr>
        <td class="td">{{ tgl_indo(substr($riwayat->created_at,0,10)) }}</td>
        <td class="td">{{ $riwayat->anamnesa }}</td>
        <td class="td">Diagnosa</td>
        <td class="td">Keterangan</td>
    </tr>
    @endforeach
</table> --}}