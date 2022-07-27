@extends('layouts.app')
@section('title','Jenis Pemeriksaan Lab ')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Input Hasil pemeriksaan laboratorium
            {{-- <small>Input indikator pemeriksaan</small> --}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/pendaftaran">Pendaftaran </a></li>
            <li class="active">Input indikator pemeriksaan</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box card-height">
                    <div class="box-header card-header">
                        <strong>Informasi Pasien</strong>
    
                    </div>
                    <div class="box-body">
                        <div class="row">
    
                            <div class="card-spac">
                                <div class="col-md-5">
                                    <strong>Nomor Pendaftaran</strong>
                                </div>
                                <div class="col-md-7">
                                    : {{ $nomorAntrian->pendaftaran->kode }}
                                </div>
                            </div>
    
                            <div class="card-spac">
                                <div class="col-md-5">
                                    <strong>Nama</strong>
                                </div>
                                <div class="col-md-7">
                                    : {{ $nomorAntrian->pendaftaran->pasien->nama }}
                                </div>
                            </div>
    
                            <div class="card-spac">
                                <div class="col-md-5">
                                    <strong>Tempat tgl lahir</strong>
                                </div>
                                <div class="col-md-7">
                                    : {{ $nomorAntrian->pendaftaran->pasien->tempat_lahir }},
                                    {{ tgl_indo($nomorAntrian->pendaftaran->pasien->tanggal_lahir) }}
                                </div>
                            </div>
    
                            <div class="card-spac">
                                <div class="col-md-5">
                                    <strong>Umur</strong>
                                </div>
                                <div class="col-md-7">
                                    : {{ hitung_umur($nomorAntrian->pendaftaran->pasien->tanggal_lahir) }} tahun
                                </div>
                            </div>

                            <div class="card-spac">
                                <div class="col-md-5">
                                    <strong>Tujuan Poliklinik</strong>
                                </div>
                                <div class="col-md-7">
                                    : {{ $nomorAntrian->poliklinik->nama??'-' }}
                                </div>
                            </div>
    
                            <div class="card-spac">
                                <div class="col-md-5">
                                    <strong>Tanggal Sekarang</strong>
                                </div>
                                <div class="col-md-7">
                                    : {{ tgl_indo(date('Y-m-d')) }}
                                </div>
                            </div>
    
                            <div class="card-spac">
                                <div class="col-md-5">
                                    <strong>Jenis Layanan</strong>
                                </div>
                                <div class="col-md-7">
                                    : {{ $nomorAntrian->perusahaanAsuransi->nama_perusahaan }}
                                </div>
                            </div>

                            <div class="card-spac">
                                <div class="col-md-12">
                                    <hr>
                                    <a href="/pendaftaran" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-6">
                <div class="box card-height">
                    <div class="box-header card-header">
                        <strong>Pemeriksaan Laboratorium</strong>
    
                    </div>
                    <div class="box-body">
                        <div class="box-body">
                            {{ Form::open(['url'=>'simpan-hasil-pemeriksaan-lab/'.$nomorAntrian->pendaftaran->id]) }}
                            {{ Form::hidden('nomor_antrian_id',$nomorAntrian->id)}}
                            
                            <table class="table table-bordered">
                                <?php $nomor =1 ;$indexTindakan=1;?>
                                @foreach($pendaftaranTindakan as $tindakan)
                                @if($tindakan->tindakan->poliklinik_id==7)
                                <tr class="danger">
                                    <td colspan="6">Nama Pemeriksaan : {{ $tindakan->tindakan->tindakan }} - {{ $indexTindakan }}</td>
                                    <input type="hidden" name="id_tindakan[]" value="{{$tindakan->tindakan->id }}">
                                </tr>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Indikator</th>
                                    <th>Nilai Rujukan</th>
                                    <th>Satuan</th>
                                    <th width="100">Hasil</th>
                                    <th>Catatan ( Opsional )</th>
                                </tr>
                                    @foreach($tindakan->tindakan->indikator as $row)
                                    <tr>
                                        <td>{{ $nomor++ }}</td>
                                        <td>{{ $row->nama_indikator }}</td>
                                        <td>{{ $row->nilai_rujukan }}</td>
                                        <td>{{ $row->satuan }}</td>
                                        <td>
                                            <input type="hidden" name="indikator_id[]" value="{{ $row->id }}">
                                            <?php
                                            $hasil = \DB::table('pendaftaran_hasil_pemeriksaan_lab')
                                            ->where('pendaftaran_id',$nomorAntrian->pendaftaran->id)
                                            ->where('indikator_pemeriksaan_lab_id',$row->id)
                                            ->first();
                                            ?>
                                            {{ Form::text('hasil[]', $hasil->hasil??null, ['class' => 'form-control hasil detail-section', 'placeholder' => 'Nilai Hasil', 'required']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('catatan[]', $hasil->catatan??null, ['class' => 'form-control hasil detail-section', 'placeholder' => 'Catatan']) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <?php $indexTindakan++?>
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2" class="text-left">
                                        <button type="submit" class="btn btn-success">Simpan Hasil</button>
                                        @if($hasilPemeriksaan)
                                        <a target="new" href="/pendaftaran/{{$nomorAntrian->id}}/input-indikator/print" target="new" class="btn btn-primary">
                                            <i class="fa fa-print"></i> Cetak PDF
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('bootstrap3-editable/js/bootstrap-editable.js')}}"></script>
<script>
$( document ).ready(function() {
	refresh_table()
    changeNilai()

    $('#indikator_pemeriksaan_lab_id').select2();
    $('#indikator_pemeriksaan_lab_id').on('change', ()=>{
        changeNilai()
    })

    $('.indikator').select2({
        placeholder: 'Cari Nama Indikator',
        ajax: {
        url: '/ajax/select2Indikator',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item.nama_indikator,
                id: item.id
                }
            })
            };
        },
        cache: true
        }
    });
});

function changeNilai(){
    let harapan =$('#indikator_pemeriksaan_lab_id option:selected').attr('data-nilai')
    $('#nilai_rujukan').val(harapan)
}

function hapus_indikator(indikator_id = null)
{
	if(indikator_id == null){
		indikator_id = $(".indikator").val();
	}

	$('.btn-hapus-indikator').prop('disabled', true)

	$.ajax({
		url: "/hasil-pemeriksaan-lab/"+indikator_id,
		type: "DELETE",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			indikator_id: indikator_id
		},
		success: function (response) {
			refresh_table()
		},
		error: function () {
			alert("error");
		}

	});
}

function refresh_table(hasResponse = null){
	if(hasResponse != null){
		return $('#table-detail-section').html(hasResponse)
	}

	$.ajax({
		url : "/hasil-pemeriksaan-lab/{{$nomorAntrian->pendaftaran->id}}",
		type : "GET",
		success : (response)=>{
			$('#table-detail-section').html(response)
            $('.editableRow').editable({
				type: 'text',
				value : '',
				url: '/ajax/hasil-pemeriksaan-lab-editable',
				title: 'Masukan data baru'
			});
			$('.editableRow').on('save', (e, editable) => {
				refresh_table()
			})
            $('#datatable').DataTable()
		}
	})
}

function tambah_indikator() {
    let indikator_pemeriksaan_lab_id = $('#indikator_pemeriksaan_lab_id option:selected').val()
    let hasil = $('.hasil').val()
    let pendaftaran_id = '{{$nomorAntrian->pendaftaran->id}}'

    if(indikator_pemeriksaan_lab_id == '' || hasil == '' || pendaftaran_id == '')
    {
      return alert('Indikator Atau Jumlah Tidak Boleh Kosong');
    }

    $.ajax({
        url: "/hasil-pemeriksaan-lab",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            indikator_pemeriksaan_lab_id : indikator_pemeriksaan_lab_id,
            hasil : hasil,
            pendaftaran_id : pendaftaran_id
        },
        success: function (response) {
            refresh_table(response)
            $('#datatable').DataTable()
            $(".hasil").val('')
        },
        error: function () {
            alert("error");
        }

    });
}
</script>
@endpush

@push('css')
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('bootstrap3-editable/css/bootstrap-editable.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <style>
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        table.dataTable {
            width: 100% !important;
        }
    </style>
@endpush
