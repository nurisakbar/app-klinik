<div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Nama</label>

    <div class="col-sm-4">
        {!! Form::text('name', null, ['class'=>'form-control','Placeholder'=>'Nama Pengguna']) !!}
    </div>
    @if($_GET['jabatan']!='user')
    <div class="col-sm-3">
        {!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'Kode']) !!}
    </div>
    @endif
</div>
<div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">Email & Password</label>

    <div class="col-sm-4">
        {!! Form::email('email', null, ['class'=>'form-control','Placeholder'=>'Email']) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::password('password', ['class'=>'form-control','Placeholder'=>'Password']) !!}
    </div>
</div>

@if($_GET['jabatan']=='dokter')
<div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">Spesialis</label>
    <div class="col-sm-4">
        {!! Form::text('spesialis',null, ['class'=>'form-control','Placeholder'=>'Spesialis']) !!}
    </div>
</div>
<div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">SIP</label>
    <div class="col-sm-4">
        {!! Form::text('sip',null, ['class'=>'form-control','Placeholder'=>'SIP']) !!}
    </div>
</div>
@endif


@if(in_array(Auth::user()->role,['bagian_pendaftaran','administrator']))
<div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Level User</label>
    <div class="col-sm-4">
        {!! Form::select('role',$user_role, $_GET['jabatan'], ['class'=>'form-control', 'id' => 'jabatan']) !!}
    </div>
</div>
@endif
<div class="form-group d-none" id="poliklinik">
    <label for="inputName" class="col-sm-2 control-label">Poliklinik</label>
    <div class="col-sm-4">
        {!! Form::select('poliklinik_id',$poliklinik, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group d-none" id="custom_info">
    <label for="inputName" class="col-sm-2 label-custom">Custom</label>
    <div class="col-sm-4">
        {!! Form::text('custom_info', null, ['class'=>'form-control custom_info']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/user?jabatan={{$jabatan}}" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>

@push('css')
<style>
    .d-none {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        cek_jabatan();
        $('#jabatan').change(function() {
            cek_jabatan();
        })
    })


    function cek_jabatan(){
        var jabatan = $("#jabatan").val();
        console.log(jabatan);
            if(jabatan == 'poliklinik') {
                $('#poliklinik').removeClass('d-none');
            } else {
                $('#poliklinik').addClass('d-none');
            }
    }
</script>
@endpush