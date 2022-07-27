@extends('layouts.app')
@section('title','Pendaftaran Pasien')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Pendaftaran Pasien
        <small>Daftar Pasien</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                  <div class="row">
                    {!! Form::open(['route'=>'pendaftaran.store']) !!}
                    {{ Form::hidden('kode', generateKodePendaftaran()) }}
                    <div class="col-md-7">
                        <h3><strong>Tujuan Pelayanan</strong></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Jenis Pendaftaran</label>
                                    {{ Form::select('jenis_pendaftaran', $jenis_pendaftaran, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Pasien</label>
                                    <select name="pasien_id" class="pasien form-control pasien_id" placeholder="Masukan Nama Pasien"></select>
                                    @error('pasien_id') <small class="text-danger">Harap pilih pasien!</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Jenis Rujukan</label>
                                    {{ Form::select('jenis_rujukan', $jenis_rujukan, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nama Perujuk ( opsional)</label>
                                    {{ Form::text('nama_perujuk', null,['class'=>'form-control','placeholder'=>'Nama Perujuk']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nomor Surat ( opsional)</label>
                                    {{ Form::number('no_surat', null,['class'=>'form-control','Placeholder'=>'Nomor Surat']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Tanggal Berlaku ( opsional)</label>
                                    {{ Form::date('tanggal_berlaku', null,['class'=>'form-control','placeholder'=>'Tanggal Berlaku']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Penanggung Jawab *)</label>
                                    {{ Form::text('penanggung_jawab', null,['class'=>'form-control penanggung_jawab','Placeholder'=>'Penanggung Jawab','required'=>'required']) }}
                                    @error('penanggung_jawab') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nomor HP *)</label>
                                    {{ Form::text('no_hp_penanggung_jawab', null,['class'=>'form-control nomor_hp_penanggung_jawab','placeholder'=>'Nomor HP','required'=>'required']) }}
                                    @error('no_hp_penanggung_jawab') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Hubungan</label>
                                    {{ Form::select('hubungan_pasien', $hubungan_pasien, null,['class'=>'form-control hubungan_pasien']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Alamat Penanggung Jawab *)</label>
                                    {{ Form::text('alamat_penanggung_jawab', null,['class'=>'form-control alamat_penanggung_jawab','Placeholder'=>'Alamat Penanggung Jawab','required'=>'required']) }}
                                    @error('alamat_penanggung_jawab') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Poliklinik</label>
                                {{ Form::select('poliklinik_id', $poliklinik, null,['class'=>'form-control poliklinik']) }}
                            </div>
                        </div>
                        <div class="col-md-8 tindakan_lab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Tindakan Lab</label>
                                        {{ Form::select('tindakan_id',  $tidakanLab, null,['class'=>'form-control tindakan_id','placeholder'=>'Pilih Tindakan']) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1"></label>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="tambahTindakanLab()">Tambah Tindakan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Dokter</label>
                                <div id="dokter"></div>
                            </div>
                        </div>

                        <div class="col-md-4 pengganti">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Dokter Pengganti</label>
                                <div id="dokter_pengganti"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Perusahaan Penjamin</label>
                                {{ Form::select('perusahaan_asuransi_id', $perusahaan_asuransi , null,['class'=>'form-control jenis_layanan perusahaan_asuransi_id','required'=>'required']) }}
                            </div>
                        </div>


                        
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%">DAFTARKAN PASIEN</button>
                        </div>
                    </div>
                    {{ Form::close()}}

                    <div class="col-md-5">
                        <h3><strong>Detail Pasien</strong></h3>
                        <hr>
                        <div class="text-center before-select">
                            <p style="padding-bottom: 30px" class="text-pilih">Harap pilih pasien</p>

                            <img src="{{ asset('image/loading.gif') }}" alt="">
                        </div>

                        <div class="after-select">
                            <div class="row">

                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>Nama pasien</strong>
                                        <small class="small-label-antrian">Pasien detail</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="detail-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>No ktp</strong>
                                        <small class="small-label-antrian">Kartu Tanda Penduduk</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="ktp-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>No telpon</strong>
                                        <small class="small-label-antrian">Nomor telpon pasien</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="telpon-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>Tempat lahir</strong>
                                        <small class="small-label-antrian">Lahir di</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="tempat-lahir-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>Tanggal lahir</strong>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="tanggal-lahir-pasien"></label>
                                    </div>
                                </div>
                                
                              </div>

                              <hr>

                              <div id="tindakan-temp"></div>
                        </div>
                    </div>
                  </div>
               
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection

@push('scripts')
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>

<script>
    $( document ).ready(function() {

        dokterPegganti();
        // check apakah hasil redirect dari form input pasien
        var str = window.location.href;
        str = str.split("/");
        if(str[5]!=undefined)
        {
            console.log('selected');
            var pasien_id = str[5];

            $('.pasien').select2({
                ajax: {
                    url: '/ajax/pasien'
                }
            });

            // Fetch the preselected item, and add to the control
            var studentSelect = $('.pasien');
            $.ajax({
                type: 'GET',
                url: '/ajax/pasien',
                data : {pasien_id:pasien_id},
            }).then(function (data) {
                console.log(data);
                // create the option and append to Select2
                var option = new Option(data.nama, data.id, true, true);
                studentSelect.append(option).trigger('change');

                // manually trigger the `select2:select` event
                studentSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });

        }

        $('.poliklinik').bind('change', function () {
            var poliklinik = $(".poliklinik").val();
            $.ajax({
                url: "/ajax/dropdown-dokter-berdasarkan-poliklinik",
                type: "get",
                data: {poliklinik:poliklinik},
                success: function(response) {
                    $("#dokter").html(response);
                    dokterPegganti();
            }});
            
            // tampilkan tindakan jika yang dipilih adalah lab
            if(poliklinik==7)
            {
                $(".tindakan_lab").show();
            }else{
                $(".tindakan_lab").hide();
            }
        });
        
    
        $('.poliklinik').trigger('change');
    
        $('.pasien').select2({
            placeholder: 'Masukan Nama Pasien',
            ajax: {
            url: '/ajax/select2Pasien',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                    console.log(item);
                    return {
                        text: item.nama.concat(' / '+item.nomor_rekam_medis).concat(' / '+item.nama_ibu),
                        id: item.id
                    }
                })
                };
            },
            cache: true
            }
        });

        $('.pasien').on("select2:select", function (e) {
            var pasien = $('.pasien').val();
            $.ajax({
                url: "/ajax/pasien",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "pasien_id": pasien
                },
                beforeSend: function () {
                    $('.before-select').show();
                    $('.after-select').hide();
                    $('.text-pilih').hide();
                },
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $('#detail-pasien').text(response.nama);
                        $('#ktp-pasien').text(response.nomor_ktp);
                        $('#telpon-pasien').text(response.nomor_hp);
                        $('#tempat-lahir-pasien').text(response.tempat_lahir);
                        $('#tanggal-lahir-pasien').text(response.tanggal_lahir);
                        $('.penanggung_jawab').val(response.penanggung_jawab);
                        $('.alamat_penanggung_jawab ').val(response.alamat_penanggung_jawab);
                        $('.hubungan_pasien').val(response.hubungan_pasien);
                        $('.nomor_hp_penanggung_jawab').val(response.nomor_hp_penanggung_jawab);
                        $(".jenis_layanan").val(response.penjamin).change();

                        $('.before-select').hide();
                        $('.after-select').show();
                    } else {
                        $('.before-select').show();
                        $('.after-select').hide();
                        $('.text-pilih').show();
                    }
                }
            });
        });
    });


    function showTindakanLab(){
        var pasien_id                   = $(".pasien_id").val();
        var tindakan_id                 = $(".tindakan_id").val();
        var perusahaan_asuransi_id      = $(".perusahaan_asuransi_id").val();
        $.ajax({
                url: "/pendaftaran-tindakan-temp",
                type: "GET",
                data: {
                    pasien_id: pasien_id,
                    perusahaan_asuransi_id : perusahaan_asuransi_id
                },
                success: function (response) {
                    $("#tindakan-temp").html(response);
                }
        });
    }

    function tambahTindakanLab(){
        var pasien_id                   = $(".pasien_id").val();
        var tindakan_id                 = $(".tindakan_id").val();
        var perusahaan_asuransi_id      = $(".perusahaan_asuransi_id").val();

        if(pasien_id==null){
            alert("Silahkan Pilih Pasien Dulu");
            exit();
        }

        if(tindakan_id==null){
            alert("silahkan pilih tindakan");
            exit();
        }

        if(perusahaan_asuransi_id==null){
            alert("pilih perusahaan asuransi");
            exit();
        }
        $.ajax({
                url: "/pendaftaran-tindakan-temp",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    pasien_id: pasien_id,
                    tindakan_id: tindakan_id,
                    perusahaan_asuransi_id : perusahaan_asuransi_id
                },
                success: function (response) {
                    console.log(response);
                    showTindakanLab();
                }
        });
    }


    function deleteTindakanTemp(id){
        $.ajax({
                url: "/pendaftaran-tindakan-temp/"+id,
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    showTindakanLab();
                }
        });
    }


    function dokterPegganti() {
        var dokter = $(".dokter").val();
        if (dokter == 0) {
            $(".pengganti").show();
            $.ajax({
                url: "/ajax/dropdown-dokter",
                type: "get",
                success: function (response) {
                    $("#dokter_pengganti").html(response);
                }
            });
        } else {
            $(".pengganti").hide();
        }
    }
</script>
@endpush

@push('css')
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>   
@endpush