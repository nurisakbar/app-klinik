@extends('layouts.app')
@section('title','Pasien Terdaftar')
@section('content')
<audio id="tingtung" src="{{asset('audio/tingtung.mp3')}}"></audio>
<div class="content-wrapper">
    <section class="content-header">
      @if(auth()->user()->role == 'kasir') 
        <h1>
          Daftar Pasien Selesai Pelayanan
          <small></small>
        </h1>
      @else
        <h1>
          Daftar Pasien Menunggu Pelayanan
          <small></small>
        </h1>
      @endif
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
           

              <?php
              $nomor_antrian    =   \DB::table('nomor_antrian');
              $jumlah_antrian   =   $nomor_antrian->whereRaw('left(created_at,10)="'.date('Y-m-d').'"');
                                    //->where('poliklinik_id',Auth::user()->poliklinik_id);
              if(session('user_id')!=null)
              {
                $jumlah_antrian = $jumlah_antrian->where('dokter_id',session('user_id'));
              }
              $jumlah_antrian = $jumlah_antrian->count();
              $sisa_antrian     =   $nomor_antrian->where('sudah_dipanggil',0)->count();
              $antrian_sekarang =   $nomor_antrian->where('sudah_dipanggil',1)
                                    ->orderBy('sudah_dipanggil','DESC')
                                    ->first();
              ?>
              <div class="row-fluid">
                @if(in_array(Auth::user()->role,['poliklinik']))
                <div class="col-md-12" style="margin-bottom:20px;margin-top:20px">
                  {{-- {{ Auth::user()}} --}}
                  <input type="hidden" id="poliklinik_id" value="{{ Auth::user()->poliklinik_id}}">
                  
                    <button type="button" class="btn btn-danger btn-lg btn-call" onclick="panggil(1)"><i class="fa fa-microphone"></i> Panggil Pasien</button>
                    <button type="button" class="btn btn-danger btn-lg btn-call" onclick="panggil(2)"><i class="fa fa-microphone"></i> Selanjutnya</button>
                 
                </div>
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3 id="jumlah_total_antrian">{{ $jumlah_antrian }}</h3>
                            <p>Total Kunjungan Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-list"></i>
                        </div>
                        
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3 id="antrian_sekarang">{{ $antrian_sekarang->nomor_antrian??0 }}<sup style="font-size: 20px"></sup></h3>
            
                            <p>Nomor Antrian Sekarang</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-checkmark-circle"></i>
                        </div>
                        
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3 id="sisa_antrian">{{ $sisa_antrian }}</h3>
            
                            <p>Sisa Antrian</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-people"></i>
                        </div>
                        
                    </div>
                </div>
                <!-- ./col -->
                @endif
            </div>

              <div class="box-body">
                      {!! Form::open(['url'=>'pendaftaran','method'=>'GET','id'=>'form']) !!}
                      <table class="table table-bordered">
                          <tr>
                              <td width="140">Tanggal Mulai</td>
                              <td>
                                  <div class="row">
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-2">
                                        {!! Form::select('poliklinik_id', $poliklinik, $poliklinik_id,['class'=>'form-control','placeholder'=>'- Semua Poli -']) !!}
                                      </div>
                                      <div class="col-md-2">
                                        {!! Form::select('perusahaan_asuransi_id', $perusahaanAsuransi, $perusahaan_asuransi_id,['class'=>'form-control','placeholder'=>'- Semua Perusahaan -']) !!}
                                      </div>
                                      <div class="col-md-4">
                                          <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                             Filter Laporan
                                          </button>
                                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#import-stock">
                                              <i class="fa fa-file-text"></i> Import Calon Pasien
                                          </button>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      </table>
                      {!! Form::close() !!}
                      <hr>
                @include('alert')
                <input type="hidden" class="cetak_id" name="cetak_id" value="{{ $_GET['cetak_id']??null}}">
                <table class="table table-bordered table-striped" id="pendaftaran-table">
                  <thead>
                      <tr>
                        {{-- <th width="10">Nomor</th> --}}
                        <th>Noreg</th>
                        <th>Rekamedis</th>
                        <th>Antrian</th>
                        <th>Inisial</th>
                        <th>Nama Pasien</th>
                        <th>Poliklinik</th>
                        <th>Nama Dokter</th>
                        <th>Perusahaan Asuransi</th>
                        <th>Status Pemeriksaan</th>
                        <th width="120">#</th>
                      </tr>
                  </thead>
              </table>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
  <!-- Modal -->
  {!! Form::open(['route'=>'pendaftaran.import_excel', 'files' => true]) !!}
    <div class="modal fade" id="import-stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Data Calon Pasien</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <td>Pilih File</td>
                    <td>
                        {!! Form::file('import_file', ['class' => 'form-control']) !!}
                    </td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Upload Calon Pasien</button>
          </div>
        </div>
      </div>
    </div>
  {!! Form::close() !!}
@endsection
@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- Get API Key -> https://responsivevoice.org/ -->
<script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
<script>
    $(function() {
      var parameter = $('#form').serialize();
      checkCetak()
      console.log(parameter);
      $('#pendaftaran-table').DataTable({
          processing: true,
          serverSide: true,
          daata: $('#form').serialize(),
          order: [[0, 'desc']],
          ajax: "/pendaftaran?tanggal_awal={{$tanggal_awal}}&tanggal_akhir={{$tanggal_akhir}}&poliklinik_id={{$poliklinik_id}}&perusahaan_asuransi_id={{$perusahaan_asuransi_id}}&type=web",
          columns: [
            // {data: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'kode', name: 'kode' },
            { data: 'nomor_rekam_medis', name: 'nomor_rekam_medis' },
            { data: 'nomor_antrian_waktu', name: 'nomor_antrian_waktu' },
            { data: 'inisial', name: 'inisial' },
            { data: 'nama', name: 'nama' },
            { data: 'nama_poliklinik', name: 'nama_poliklinik' },
            { data: 'nama_dokter', name: 'nama_dokter' },
            { data: 'nama_perusahaan', name: 'nama_perusahaan' },
            { data: 'status_pelayanan', name: 'status_pelayanan' },
            { data: 'action', name: 'action' }
          ]
      });
    });

    

    function checklist(id){
      console.log(id);
      $.ajax({
        url: "ajax/checklist_poli_kebidanan",
        type: "get", //send it through get method
        data: {pendaftaran_id:id},
        success: function(response) {
          console.log(response)
        },
        error: function(xhr) {
          //Do Something to handle error
        }
      });
    }

    function panggil(type){
      console.log("sas");
      // type 1 :  panggil, 2 : selanjutnya
      var bell = document.getElementById('tingtung');
        bell.pause();
        bell.currentTime = 0;
        bell.play();
        durasi_bell = bell.duration * 770;

        setTimeout(function () {
          $.ajax({
          url: '/nomor_antrian_call',
          type: 'GET',
          data: {poliklinik_id:$("#poliklinik_id").val(),type:type} ,
          success: function (response) {
            console.log(response);
            // console.log(response.antrian_sekarang);
              responsiveVoice.speak("Nomor Antrian, "+response.antrian_sekarang+", silahkan menuju ke, "+response.poliklinik_tujuan+"", "Indonesian Female", {
                rate: 0.9,
                pitch: 1,
                volume: 1
            });

            $('#antrian_sekarang').text(response.antrian_sekarang);
            $('#jumlah_total_antrian').text(response.jumlah_total_antrian);
            $('#sisa_antrian').text(response.sisa_antrian);

            if(response.antrian_sekarang==response.jumlah_total_antrian)
            {
              $(".btn-call").prop('disabled', true);
            }

          },
          error: function () {
              //alert("error");

          }
      }); 


        }, durasi_bell);



        
        //setTimeout(function() { location.reload() }, 10000);

    }


    function checkCetak(){
      var cetak_id = $(".cetak_id").val();
      if(cetak_id>0)
      {
        window.open('pembayaran/' +cetak_id + '/kwitansi','_blank');
      }
    }
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
