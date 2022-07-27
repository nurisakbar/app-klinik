@extends('layouts.app')
@section('title','Kelola Data Pasien ObatRacik')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Kelola Data Pasien
            <small>Pasien Obat Non Racik</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Pasien Obat Non Racik</li>
        </ol>
    </section>

    @include('pendaftaran._informasi_umum')

    <section class="content" style="margin-top: -30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('pendaftaran._tab')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Form Input Obat Non Racik</h4>
                                <hr>
                                <table class="table table-bordered table-bordered">
                                    <tr>
                                        <th colspan="2">FORM INPUT OBAT NON RACIK</th>
                                    </tr>
                                    <tr>
                                        <td>Pilih Barang</td>
                                        <td>
                                            <select name="barang_id" id="barang_id" class='select2 form-control' style="width:100%">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukan jumlah obat">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Satuan</td>
                                        <td>
                                            <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Masukan satuan obat">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Aturan Pakai</td>
                                        <td>
                                            <textarea name="aturan_pakai" id="aturan_pakai" class="form-control"
                                                placeholder="Aturan pakai obat"
                                                cols="30" rows="10"></textarea>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="btn btn-primary add-item" onClick="addObatRacik(this)"
                                                data-jenis='tindakan'>
                                                <i class="fa fa-plus"></i>
                                                Tambah
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4>Daftar Obat Non Racik</h4>
                                <hr>
                                <div id="table-section">
                                    <table class="table table-bordered table-striped" width="100%" id="obat-racik-table">
                                        <thead>
                                            <tr>
                                                <th width="10">Nomor</th>
                                                <th>Kode</th>
                                                <th>Nama Obat</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                    </table>
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

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush


@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('datatables/datatables.min.js') }}"></script>
<script>
    getObatRacik()
    $('#barang_id').select2({
        placeholder: 'Cari Barang',
        multiple: false,
        ajax: {
            url: '/ajax/select2Barang',
            dataType: 'json',
            delay: 250,
            multiple: false,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama_barang,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    
    function getObatRacik() {
        $('#obat-racik-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				url : '/resume/obatRacik',
				data : {
					id : '{{$pendaftaran->id}}',
                    jenis : 'non racik'
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
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
                {
                    data: 'aturan_pakai',
                    name: 'aturan_pakai'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }
	
	function addObatRacik(btn) {
        let barang_id = $('#barang_id').select2('data')[0].id
        let jumlah = $('#jumlah').val()
        let satuan = $('#satuan').val()
        let aturan_pakai = $('#aturan_pakai').val()
        $.ajax({
            url : '/obat-racik-add-item/{{$pendaftaran->id}}',
            method : 'POST',
            data : {
				_token : '{{csrf_token()}}',
                barang_id : barang_id,
                jumlah : jumlah,
                satuan : satuan,
                aturan_pakai : aturan_pakai,
                jenis : 'non racik'
            },
            success : (response)=>{
                $('#table-section').html(response)
				getObatRacik()
            }
        })
	}

	function removeObatRacik(btn) {
        let id = btn.getAttribute('data-id')
        $.ajax({
            url :'/obat-racik-remove-item/'+id,
            method : 'DELETE',
            data : {
                _token : '{{csrf_token()}}'
            },
            success : (response)=>{
                $('#table-section').html(response)
				getObatRacik()
            }
        })
    }
</script>

@endpush