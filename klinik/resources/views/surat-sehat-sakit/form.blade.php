
<div class="form-group">
    <label class="col-sm-2 control-label">Tanggal Mulai</label>
    <div class="col-sm-3">
        {!! Form::date('tanggal_mulai', null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Pasien</label>
    <div class="col-sm-10">
        <select name="pasien_id" id="pasien" class="pasien form-control" style="height: 100px;" placeholder="Masukan Nama Pasien"></select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Dokter</label>
    <div class="col-sm-10">
        {{ Form::select('user_id', $dokter, null, ['class' => 'form-control']) }}
    </div>
</div>

@if($tipe == 'surat-sehat')
    <div class="form-group">
        <label class="col-sm-2 control-label">Keperluan</label>
        <div class="col-sm-10">
            {!! Form::text('keperluan', null, ['class'=>'form-control','Placeholder'=>'Keperluan']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Tekanan Darah</label>
        <div class="col-sm-10">
            {!! Form::text('tekanan_darah', null, ['class'=>'form-control','Placeholder'=>'Tekanan darah']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Tinggi Badan</label>
        <div class="col-sm-10">
            {!! Form::text('tinggi_badan', null, ['class'=>'form-control','Placeholder'=>'Tinggi Badan']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Berat Badan</label>
        <div class="col-sm-10">
            {!! Form::text('berat_badan', null, ['class'=>'form-control','Placeholder'=>'Berat badan']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Golongan Darah</label>
        <div class="col-sm-10">
            {!! Form::select('golongan_darah', $golongan_darah ,null, ['class'=>'form-control']) !!}
        </div>
    </div>

@else
    <div class="form-group">
        <label class="col-sm-2 control-label">Diagnosa</label>
        <div class="col-sm-10">
            {!! Form::text('diagnosa' ,null, ['class'=>'form-control','placeholder'=>'Diagnosa']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Tanggal Selesai</label>
        <div class="col-sm-3">
            {!! Form::date('tanggal_selesai', null, ['class'=>'form-control']) !!}
        </div>
    </div>
@endif

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/surat-sehat-sakit" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>



@push('scripts')
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script>
$( document ).ready(function() {

    $('.pasien').select2({
        placeholder: 'Cari Nama Pasien',
        ajax: {
        url: '/ajax/select2Pasien',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item.nama,
                id: 1
                }
            })
            };
        },
        cache: true
        }
    });
});
</script>
@endpush

@push('css')
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>  
@endpush