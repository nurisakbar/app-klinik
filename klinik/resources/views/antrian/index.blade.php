@extends('layouts.topnavlayout')
@section('title','Antrian')
@section('content')
<!-- load file audio bell antrian -->
<audio id="tingtung" src="{{asset('audio/tingtung.mp3')}}"></audio>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Antrian
            <small>Panggilan antrian</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Antrian</li>
        </ol>
    </section>

    <section class="content">
        <div id="detail-section">

        </div>
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-table"></i>List Antrian</li>
                    </ul>
                    <div class="tab-content">
                        <div class="row" >
                            <div class="col-md-12">
                                <table class="table table-bordered" id="antrian-table">
                                    <thead>
                                        <tr>
                                            <th>Nomor Antrian</th>
                                            <th>Panggil</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-table"></i>Buat Antrian</li>
                    </ul>
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <div class="form-group antrian-select" style="text-align:left">
                                    <label for="pendaftaran_id">Nomor Pendaftaran*</label>
                                    <select name="pendaftaran_id" id="pendaftaran_id" class="select2 form-control">
                                        
                                    </select>
                                </div>
                                <div id="nomor-antrian-section">
                                    {{$nomorAntrian}}
                                </div>
                                <button class="btn btn-success" id="ambil-nomor">Ambil Nomor</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <style>
        #antrian-table tbody tr td {
            text-align:center;
        }
        #nomor-antrian-section {
            font-weight : bold;
            font-size : 72pt;
        }
    </style>
@endpush

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- Responsivevoice -->
<!-- Get API Key -> https://responsivevoice.org/ -->
<script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    $(document).ready(()=>{
        updateDetail()
    })

    $('#ambil-nomor').on('click', ()=>{
        try {
            let nomor_pendaftaran = $('#pendaftaran_id').select2('data')[0].id
            $.ajax({
                url : '/antrian',
                method : 'POST',
                data : {
                    _token : '{{csrf_token()}}',
                    pendaftaran_id : nomor_pendaftaran
                },
                success : (response)=>{
                    $('#nomor-antrian-section').html(response)
                    updateDetail()
                    antrianTable.ajax.reload()
                }
            })
        } catch (error) {
            $('.antrian-select').addClass('has-error')
            $('.antrian-select label').html('Nomor Pendaftaran* (Wajib di isi)')
            return
        }

    })

    $('#pendaftaran_id').select2({
        placeholder: 'Cari Pendaftaran',
        multiple: false,
        ajax: {
            url: '/ajax/select2Pendaftaran',
            dataType: 'json',
            delay: 250,
            multiple: false,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.kode,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    const antrianTable = $('#antrian-table').DataTable({
        order : [[0, 'DESC']],
        processing: true,
        serverSide: true,
        ajax: '/antrian',
        columns: [
            { data: 'nomor_antrian', name: 'nomor_antrian' },
            { data: 'panggil', name: 'panggil' }
        ]
    });

    function panggil(nomor_antrian, id) {
        var bell = document.getElementById('tingtung');
        bell.pause();
        bell.currentTime = 0;
        bell.play();
        durasi_bell = bell.duration * 770;

        setTimeout(function () {
            responsiveVoice.speak("Nomor Antrian, "+nomor_antrian+" , menuju, loket, 1", "Indonesian Male", {
                rate: 0.9,
                pitch: 1,
                volume: 1
            });
        }, durasi_bell);

        updateAntrian(id)

    }

    function updateAntrian(id) {
        $.ajax({
            url : '/antrian/'+id,
            type : 'PUT',
            data : {
                _token : '{{csrf_token()}}',
                status : 1
            },
            success:(response)=>{
                if(response.status){
                    antrianTable.ajax.reload()
                    updateDetail()
                }
            }
        })
    }

    function updateDetail() {
        $.ajax({
            url : '/antrian/show',
            type : 'GET',
            success : (html)=>{
                console.log(html);
                $('#detail-section').html(html)
            }
        })
    }
</script>
@endpush

