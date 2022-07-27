<h4>Rekap Kehadiran Tahun {{ date('Y')}}</h4>
<table class="table table-bordered">
  @foreach($statusKehadiran as $stkh)
  <tr>
    <td>{{ $stkh }}</td>
    <td> : {{ rekapKehadiranSetahun($pegawai->id,date('Y'),strtolower($stkh)) }}</td>
  </tr>
  @endforeach

</table>