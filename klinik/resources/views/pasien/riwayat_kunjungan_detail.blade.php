<table class="table table-bordered">
    <tr>
        <th colspan="2">  INFORMASI UMUM</th>
    </tr>
    <tr>
        <td>Tanggal Kunjungan</td>
        <td>{{ $pendaftaran->created_at }}</td>
    </tr>
    <tr>
        <td>Poliklinik</td>
        <td>{{ $pendaftaran->poliklinik->nama }}</td>
    </tr>
    <tr>
      <td>Dokter</td>
      <td>{{ $pendaftaran->dokter->name }}</td>
  </tr>
    <tr>
        <td>Anamnesa</td>
        <td>
          {{ $pendaftaran->pendaftaran->anamnesa==null?$pendaftaran->anamnesa:$pendaftaran->pendaftaran->anamnesa }}</td>
    </tr>
</table>



<h4>Tanda Tanda Vital</h4>
<table class="table table-bordered">
  <tr>
    <td>Berat Badan</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['berat_badan']}}</td>
  </tr>
  <tr>
    <td>Tekanan Darah</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['tekanan_darah']}}</td>
  </tr>
  <tr>
    <td>Suhu Tubuh</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['suhu_tubuh']}}</td>
  </tr>
  <tr>
    <td>Tinggi Badan</td>
    <td >{{ $pendaftaran->pendaftaran->tanda_tanda_vital['tinggi_badan']}}</td>
  </tr>
  <tr>
    <td>Nadi</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['nadi']}}</td>
  </tr>
  <tr>
    <td>RR</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['rr']}}</td>
  </tr>
  <tr>
    <td>Saturasi O2</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['saturasi_o2']}}</td>
  </tr>
  <tr>
    <td>Fungsi Penciuman</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['fungsi_penciuman']}}</td>
  </tr>
  <tr>
    <td>Pernafasan</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['pernafasan']}}</td>
  </tr>
  <tr>
    <td>Lingkar Perut</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['lingkar_perut']}}</td>
  </tr>
  <tr>
    <td>DJJ</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['djj']}}</td>
  </tr>
  <tr>
    <td>Kesadaran</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['kesadaran']}}</td>
  </tr>
  <tr>
    <td>TFU</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['tfu']}}</td>
  </tr>
  <tr>
    <td>IMT</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['imt']}}</td>
  </tr>
  <tr>
    <td>Asuhan Keperawatan</td>
    <td>{{ $pendaftaran->pendaftaran->tanda_tanda_vital['asuhan_keperawatan']??'-'}}</td>
  </tr>
</table>

<h4>Riwayat Tindakan</h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Nomor</th>
      <th>Kode ICD 9</th>
      <th>Nama Tindakan</th>
      <th>Anamnesa</th>
    </tr>
  </thead>
  <tbody>
    @foreach($tindakan as $td)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{$td->tindakan->icd->desc_short??'-'}} {{ $td->poliklinik_id }}</td>
        <td>{{$td->tindakan->tindakan}}</td>
        <td>{{$td->anamnesa}}
          @if($td->poliklinik_id==1)
            <br>Nomor Gigi : <b>{{$td->kode_gigi==null?'':$td->kode_gigi}}</b>
          @endif
        </td>
      </tr>
      @if($td->poliklinik_id==1)
      <tr>
        <td colspan="4"><b>Pemeriksaan Klinis : </b>{{ $td->pemeriksaan_klinis}}</td>
      </tr>
      @endif
    @endforeach
  </tbody>
</table>

<h4>Riwayat Diagnosa</h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Nomor</th>
      <th>Kode ICD</th>
      <th>Nama Diagnosa</th>
    </tr>
  </thead>
  <tbody>
    @foreach($diagnosa as $da)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{$da->icd->kode}}</td>
      <td>{{$da->icd->indonesia}}</td>
    </tr>
    @endforeach
  </tbody>
  </tbody>
</table>

<h4>Riwayat Obat Non Racik</h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Nomor</th>
      <th>Nama Obat</th>
      <th>Jumlah</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @foreach($obatNonRacik as $obtNon)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{$obtNon->barang->nama_barang }}</td>
      <td>{{$obtNon->jumlah}}</td>
      <td>{{$obtNon->aturan_pakai}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<h4>Riwayat Obat Racik</h4>
<table class="table table-bordered">
  <tr>
      <th width="10">No</th>
      <th>Jumlah Kemasan</th>
      <th>Aturan Pakai</th>
      <th>Detail</th>
  </tr>
  @if($pendaftaranResepRacik->count() < 1)
  <tr>
      <td colspan="4">Belum Ada Data</td>
  </tr>
  @else
      @foreach($pendaftaranResepRacik->get() as $row)
      <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $row->jumlah_kemasan}} - {{ $row->satuan->satuan }}</td>
          <td>{{ $row->aturan_pakai}}</td>
          <td>
              @foreach($row->detail as $item)
              - {{ $item->barang->nama_barang}} x {{ $item->jumlah}}
              @if(count($row->detail)>1)
              <br>
              @endif
              @endforeach
          </td>
      </tr>
      @endforeach
  @endif
</table>