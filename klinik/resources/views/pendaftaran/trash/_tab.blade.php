<ul class="nav nav-tabs">
    <li class="nav-item {{ Request::segment(4)=='tindakan'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/tindakan">Tindakan</a>
    </li>
    <li class="nav-item {{ Request::segment(4)=='diagnosa'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/diagnosa">Diagnosa</a>
    </li>
    <li class="nav-item {{ Request::segment(4)=='obat_racik'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/obat_racik">Obat Racik</a>
    </li>
    <li class="nav-item {{ Request::segment(4)=='obat_non_racik'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/obat_non_racik">Obat Non Racik</a>
    </li>
    <li class="nav-item {{ Request::segment(4)=='e_medical_record'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/e_medical_record">E Medical Record</a>
    </li>
    <li class="nav-item {{ Request::segment(4)=='rujukan_laboratorium'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/rujukan_laboratorium">Rujukan Laboratorium</a>
    </li>
    <li class="nav-item ml-auto">
      <a style="margin-left: 550px" href="/pendaftaran/{{ $pendaftaran->id }}/selesai" class="btn btn-primary ml-2">Selesai</a>
    </li>
  </ul>

  
  