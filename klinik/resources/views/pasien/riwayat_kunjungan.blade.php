<table class="table table-bordered" id="tabel-data2">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nomor Pendaftaran</th>
            <th>Perusahaan Penjamin</th>
            <th>Poliklinik</th>
            <th>#</th>
        </tr>
    </thead>

    <tbody>
        @foreach($riwayatKunjungan as $row)
            <tr>
                <td>{{ $row->tanggal_kunjungan }}</td>
                <td>{{ $row->kode }}</td>
                <td>{{ $row->perusahaan_penjamin }}</td>
                <td>{{ $row->poliklinik }}</td>
                <td>
                    <button type="button" onClick="lihatRiwayat({{$row->id}})" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Lihat Riwayat
                      </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Kunjungan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="riwayat"></div>
        </div>
        <div class="modal-footer">
            <a href="" id="resume-medis" class="btn btn-primary">Cetak Resume Medis</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>




@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#tabel-data2').DataTable();
    });


    function lihatRiwayat(id){
        console.log(id);
        $.ajax({
        url: "/log-riwayat-kunjungan/"+id,
        type: 'GET',
        success: function(res) {
            $("#riwayat").html(res);
            $("#resume-medis").attr("href", "/pendaftaran/"+id+"/cetak_rekamedis");
        }
    });
    }
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush