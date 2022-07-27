<style>
    body{
        font-size:10px;
    }
    .pembatas{
      
    
        width: 200%;
        margin-left:-30px;
        margin-top:-50px;
        margin-bottom:-50px;
        text-transform: uppercase;
        page-break-after:always;
    }
</style>

@foreach ($dataCetak as $item)
<div class="pembatas">
    <p>
        <b>{{ $setting->nama_instansi }} ( {{ $setting->nomor_telpon }} )</b><br>
        Apoteker : {{ Auth::user()->name }}<br>
        <span style="font-size: 8.5px">SIPA : 19790526/SIPA_32.01/DPMPTSP/2021/2.1/00177</span><br>
        {{ $pendaftaran->pasien->nomor_rekam_medis}} - <b>{{ $pendaftaran->pasien->nama}}</b>
        <br>
    <b>{{ date("d/m/Y", strtotime($pendaftaran->pasien->tanggal_lahir))}}</b><br>
    {{ $pendaftaran->kode }}  {{ date('d/m/Y H:i')}} <br>ED : <br>
    {{ $item['barang']}}  - {{ $item['jumlah']}}<br>
    {{ $item['aturan_pakai']}}
    </p>
</div>

@endforeach
