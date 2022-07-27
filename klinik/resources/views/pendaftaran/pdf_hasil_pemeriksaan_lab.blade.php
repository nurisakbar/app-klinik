<style>
    *{
        font-family: 'Arial';
        font-size : 10pt;
    }

    .const{
        margin : 3% 0% 3% 8%;
    }

    table{
        width : 90%;
    }

    .const .centered-table {
        text-align :center !important;
    }

    .centered-table td{
        padding:2px
    }

</style>
<div>
    @include('surat.kop_surat')
    <div style="float:left;margin-top:5%;margin-left:5%;">
        <strong>HASIL PEMERIKSAAN LABORATORIUM</strong>
    </div>
</div>
<div style="clear:both">

</div>
<hr style="margin:0% 5%">
<div style="width:100%">
    <div class="const">
        <table style="margin-bottom:25px;">
            <tr style="background-color : #EEEEEE">
                <th colspan=2 style="text-align:left;width:40%">Dokter</th>
                <th colspan=2 style="text-align:left">Pasien</th>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: {{$nomorAntrian->dokter->name}}</td>
                <td>Nama</td>
                <td>: {{$nomorAntrian->pendaftaran->pasien->nama}}</td>
            </tr>
            <tr style="background-color : #EEEEEE">
                <td></td>
                <td></td>
                <td style="vertical-align:top">Alamat</td>
                <td>: {{$nomorAntrian->pendaftaran->pasien->alamat}} </td>
            </tr>
            <tr>
                <td>Pembayaran</td>
                <td>: Tunai</td>
                <td>Jenis Kelamin</td>
                <td>: {{ucWords ($nomorAntrian->pendaftaran->pasien->jenis_kelamin)}}</td>
            </tr>
            <tr style="background-color : #EEEEEE">
                <td></td>
                <td></td>
                <td>Umur</td>
                <td>: {{$nomorAntrian->pendaftaran->pasien->tanggal_lahir}}</td>
            </tr>
            <tr>
                <td>Tanggal, Jam</td>
                <td>: {{date('d F Y - h:i', strtotime(now()))}}</td>
                <td>No. Lab / RM</td>
                <td>: -</td>
            </tr>
        </table>

        <table>
            @foreach($tindakanLab as $tindakan)
                @if($tindakan->tindakan->poliklinik_id==7)
                <tr>
                    <td colspan="4">Pemeriksaan : {{ $tindakan->tindakan->tindakan}}</td>
                </tr>
                <tr style="color:white;background-color:#C85C5C;padding:16px 0">
                    <th width="20">No</th>
                    <th>Parameter</th>
                    <th>Satuan</th>
                    <th>Hasil</th>
                    <th>Nilai Normal</th>
                </tr>
                @foreach(\App\Models\HasilPemeriksaanLab::
                where('pendaftaran_id',$nomorAntrian->pendaftaran->id)
                ->where('tindakan_id',$tindakan->tindakan->id)
                ->get() as $hasil)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $hasil->indikator->nama_indikator}}</td>
                    <td>{{ $hasil->indikator->satuan}}</td>
                    <td>{{ $hasil->hasil}}</td>
                    <td>{{ $hasil->indikator->nilai_rujukan}}</td>
                </tr>                
                @endforeach
            @endif
            @endforeach
        </table>

        <div style="border-top : dashed 1px #C85C5C; width:86%;
            margin:2%;margin-bottom:100px;padding-top:10px">
            Catatan :
        </div>
        <div style=" text-align:center;
            width:150px;height:150px;
            
            font-size:10pt;float:right;margin-right:15%">
            Analisis Laboratorium
            <br> <br> <br> <br> <br> <br> <br> <br> <br>
            {{ Auth::user()->name??'-'}}
        </div>
        </div>
    </div>
</div>
