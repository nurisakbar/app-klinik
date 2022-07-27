@extends('layouts.app')
@section('title','Pendaftaran Pasien Baru')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tanda Tanda Vital Dan Pemeriksa Klinis
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
      {!! Form::model($pendaftaran,['route'=>['pendaftaran.input_tanda_vital_store',$nomorAntrian->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-xs-8">
            <div class="box">
              <div class="box-body">
                  @include('validation_error')
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Berat Badan</label>
                        {!! Form::text('berat_badan', null, ['class'=>'form-control berat_badan','Placeholder'=>'Berat Badan','onKeyUp'=>'hitungIMT()']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Tinggi Badan</label>
                        {!! Form::text('tinggi_badan', null, ['class'=>'form-control tinggi_badan','Placeholder'=>'Tinggi Badan','onKeyUp'=>'hitungIMT()']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Tekanan Darah</label>
                        {!! Form::text('tekanan_darah', null, ['class'=>'form-control','Placeholder'=>'Tekanan Darah']) !!}
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Suhu Tubuh</label>
                        {!! Form::text('suhu_tubuh', null, ['class'=>'form-control','Placeholder'=>'Suhu Tubuh']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Nadi</label>
                        {!! Form::text('nadi', null, ['class'=>'form-control','Placeholder'=>'Nadi']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>RR</label>
                        {!! Form::text('rr', null, ['class'=>'form-control','Placeholder'=>'RR']) !!}
                      </div>
                    </div>



                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Saturasi O2</label>
                        {!! Form::text('saturasi_o2', null, ['class'=>'form-control','Placeholder'=>'Saturasi O2']) !!}
                        <input type="hidden" name="pernafasan" value="">
                      </div>
                    </div>

                    {{-- <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Pernafasan</label>
                        {!! Form::text('pernafasan', null, ['class'=>'form-control','Placeholder'=>'Pernafasan']) !!}
                        
                      </div>
                    </div> --}}

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Fungsi Penciuman</label>
                        {!! Form::select('fungsi_penciuman',['Normal'=>'Normal','Tidak Normal'=>'Tidak Normal'], null, ['class'=>'form-control','Placeholder'=>'Fungsi Penciuman']) !!}
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Lingkar Perut</label>
                        {!! Form::text('lingkar_perut', null, ['class'=>'form-control','Placeholder'=>'Lingkar Perut']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>DJJ</label>
                        {!! Form::text('djj', null, ['class'=>'form-control','Placeholder'=>'DJJ']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Kesadaran</label>
                        {!! Form::text('kesadaran', null, ['class'=>'form-control','Placeholder'=>'kesadaran']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>TFU</label>
                        {!! Form::text('tfu', null, ['class'=>'form-control','Placeholder'=>'TFU']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>IMT</label>
                        {!! Form::text('imt', null, ['class'=>'form-control imt','Placeholder'=>'imt','readonly'=>'readonly']) !!}
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Status Alergi</label>
                        <div class="row">
                          <div class="col-sm-1" style="width:10px;">
                            <input type="checkbox" id = 'status_alergi' name="status_alergi">
                          </div>
                          <div class="col-sm-10">
                              {!! Form::text('status_alergi_value', null, [ 'id' => 'status_alergi_value', 'class'=>'form-control','Placeholder'=>'Status Alergi','disabled']) !!}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Jenis Kasus</label>
                        {!! Form::select('jenis_kasus',['baru'=>'Jenis Kasus Baru','lama'=>'Jenis Kasus Lama'], null, ['class'=>'form-control']) !!}
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group col-sm-12">
                        <label>Asuhan Keperawatan</label>
                        {!! Form::text('asuhan_keperawatan', null, ['class'=>'form-control','Placeholder'=>'Asuhan Keperawatan']) !!}
                      </div>
                    </div>

                  </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
                <div class="box-body text-center">
                    <img src="https://img.pikbest.com/png-images/qiantu/cute-cartoon-little-girl-medical-patient-in-hospital-gown_2558435.png!c1024wm0/compress/true/progressive/true/format/webp/fw/1024" width="200">
                    <hr>
                    <table class="table table-bordered text-left">
                      <tr>
                        <td width="160">Nama Lengkap</td>
                        <td>{{$pendaftaran->pasien->nama}}</td>
                      </tr>
                      <tr>
                        <td>Nomor RM</td>
                        <td>{{$pendaftaran->pasien->nomor_rekam_medis}}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Lahir</td>
                        <td>{{ $pendaftaran->pasien->tanggal_lahir }} / {{ hitung_umur($pendaftaran->pasien->tanggal_lahir) }} tahun</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>
                          <a target="new" href="/pasien/{{ $pendaftaran->pasien->id }}?tab=riwayat_kunjungan" class="btn btn-primary"><i class='fa fa-eye' aria-hidden='true'></i> Lihat Riwayat Kunjungan</a>
                        </td>
                      </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <div class="box">
          <div class="box-body">
            <h3>Riwayat Penyakit</h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4>Form Input Riwayat Penyakit</h4>
                    <hr>
                    <table class="table table-bordered table-bordered">
                        <tr>
                            <th colspan="2">FORM INPUT RIWAYAT PENYAKIT</th>
                        </tr>
                        <tr>
                            <td>Pilih Riwayat</td>
                            <td>
                                <select name="riwayat_penyakit_id" id="riwayat_penyakit_id" class='select2 form-control'>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="btn btn-primary add-item" onClick="addRiwayatPenyakit(this)" >
                                    <i class="fa fa-plus"></i>
                                    Tambah
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Daftar Riwayat Penyakit</h4>
                    <hr>
                    <div id="table-riwayat-penyakit">
                      <table class="table table-bordered table-striped" width="100%" id="riwayat-penyakit-table">
                                      <thead>
                                          <tr>
                                              <th width="10">Nomor</th>
                                              <th width="10">Kode</th>
                                              <th>Riwayat Penyakit</th>
                                              <th width="70">#</th>
                                          </tr>
                                      </thead>
                        <tbody>
                          <tr>
                            <td colspan=3 style="text-align:center">Tidak ada riwayat penyakit</td>
                          </tr>
                        </tbody>
                                  </table>
                              </div>
                </div>
                <div class="col-md-12">
                  <hr>
                  <div class="form-group">
                    <div class="col-sm-offset-0 col-sm-10">
                        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
                        <a href="/pendaftaran" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
                    </div>
                </div>
                </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
      </section>
  </div>
@endsection



@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{asset('/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(document).ready(function () {
		    getRiwayatPenyakit()
        $('#riwayat_penyakit_id').select2({
            placeholder: 'Cari Riwayat Penyakit',
            multiple: false,
            ajax: {
                url: '/ajax/select2ICD',
                dataType: 'json',
                delay: 250,
                multiple: false,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.indonesia,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.input').attr('disabled', 'disabled')

        $("#status_alergi").change(function () {
            $('#status_alergi_value').prop('disabled', true)
            $('#status_alergi_value').val('')
            if (this.checked) {
                $('#status_alergi_value').prop('disabled', false)
            }
        });

        $(".check").click(function () {
            let name = $(this).attr('data-name');
            let status = $('.input-' + name).attr('disabled');

            if (status === undefined) {
                $('.input-' + name).attr('disabled', 'disabled');
            }

            if (status == "disabled") {
                $('.input-' + name).removeAttr('disabled');
            }

            return true;
        });
    });


  function hitungIMT(){
    console.log("menghitung IMT");
    var berat_badan   = $(".berat_badan").val();
    var tinggi_badan  = $(".tinggi_badan").val();
    if(berat_badan!='' && tinggi_badan!='')
    {
      var imt           = berat_badan/ ((tinggi_badan*2)/100);
      $(".imt").val(imt.toFixed(2));
    }
    
  }


	function getRiwayatPenyakit() {
        $('#riwayat-penyakit-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				url : '{{ route("resume.riwayatPenyakit") }}',
				data : {
					id : '{{$pendaftaran->id}}'
				}
			},
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'tbm_icd',
                    name: 'tbm_icd'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

	function addRiwayatPenyakit(btn) {
        let riwayatPenyakit = $('#riwayat_penyakit_id').find(':selected').val();
        if(riwayatPenyakit ==undefined) {
          alert('Silahkan Pilih Penyakit');
        }
        $.ajax({
            url : '/riwayat-penyakit-add-item/{{$pendaftaran->id}}',
            method : 'POST',
            data : {
				_token : '{{csrf_token()}}',
                tbm_icd : riwayatPenyakit,
            },
            success : (response)=>{
                $('#table-riwayat-penyakit').html(response)
				getRiwayatPenyakit()
            }
        })
	}

	function removeRiwayatPenyakit(btn) {
        let id = btn.getAttribute('data-id')
        $.ajax({
            url :'/riwayat-penyakit-remove-item/'+id,
            method : 'DELETE',
            data : {
                _token : '{{csrf_token()}}'
            },
            success : (response)=>{
                $('#table-riwayat-penyakit').html(response)
				getRiwayatPenyakit()
            }
        })
    }
</script>

@endpush
