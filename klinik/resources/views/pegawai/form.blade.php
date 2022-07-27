<div class="form-group">
    <label class="col-sm-2 control-label">Nama Pegawai</label>
    <div class="col-sm-4">
        {!! Form::text('nama', null, ['class'=>'form-control','Placeholder'=>'Nama']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">NIP Pegawai</label>
    <div class="col-sm-4">
        {!! Form::text('nip', null, ['class'=>'form-control','Placeholder'=>'NIP']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">User</label>
    <div class="col-sm-4">
        <select name="user_id" id="user" class="users form-control" style="height: 100px;" placeholder="Masukan Nama User"></select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">No HP</label>
    <div class="col-sm-4">
        {!! Form::number('no_hp', null, ['class'=>'form-control','Placeholder'=>'No HP']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tempat, Tanggal Lahir</label>
    <div class="col-sm-4">
        {!! Form::text('tempat_lahir', null, ['class'=>'form-control','Placeholder'=>'Tempat lahir']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::date('tanggal_lahir', null, ['class'=>'form-control','Placeholder'=>'Nama']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kelompok pegawai</label>
    <div class="col-sm-4">
        {!! Form::select('kelompok_pegawai_id', $kelompok_pegawai,null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Agama</label>
    <div class="col-sm-4">
        {!! Form::select('agama', $agama, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Kelamin</label>
    <div class="col-sm-10">
        <div class="form-check form-check-inline">
            {{Form::radio('jenis_kelamin','pria',['class'=>'form-check-input'])}}
            <label class="form-check-label ml-2" for="inlineRadio1">Pria</label>
            {{Form::radio('jenis_kelamin','wanita',['class'=>'form-check-input'])}}
            <label class="form-check-label ml-2" for="inlineRadio2">Wanita</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Alamat</label>
    <div class="col-sm-4">
        {!! Form::text('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Gaji Pokok</label>
    <div class="col-sm-4">
        <div class="input-group">
            <span class="input-group-addon">Rp</span>
            {!! Form::number('gaji_pokok', null, ['class'=>'form-control','Placeholder'=>'Gaji Pokok']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tunjangan Kehadiran</label>
    <div class="col-sm-4">
        <div class="input-group">
            <span class="input-group-addon">Rp</span>
            {!! Form::number('tunjangan_kehadiran', null, ['class'=>'form-control','Placeholder'=>'Tunjangan Kehadiran']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nama Bank</label>
    <div class="col-sm-4">
        {!! Form::select('nama_bank', $bank, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nomor Rekening</label>
    <div class="col-sm-4">
        {!! Form::number('nomor_rekening', null, ['class'=>'form-control','Placeholder'=>'No Rekening']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tanggal masuk & Keluar</label>
    <div class="col-sm-4">
        {!! Form::date('tanggal_masuk', null, ['class'=>'form-control','Placeholder'=>'Tanggal masuk']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::date('tanggal_keluar', null, ['class'=>'form-control','Placeholder'=>'Tanggal keluar']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/pegawai" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>

@push('scripts')
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script>
$( document ).ready(function() {
    $('.users').select2({
        placeholder: 'Cari Nama User',
        ajax: {
        url: '/ajax/select2User',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                console.log(item);
                return {
                text: item.name,
                id: item.id
                }
            })
            };
        },
        cache: true
        }
    });

    var str = window.location.href;
    str = str.split("/");
    if(str[5]!=undefined)
    {
        var pegawai_id = str[4];

        $('.users').select2({
            ajax: {
                url: '/ajax/user'
            }
        });

        // Fetch the preselected item, and add to the control
        var usersSelect = $('.users');
        $.ajax({
            type: 'GET',
            url: '/ajax/user',
            data : {pegawai_id:pegawai_id},
        }).then(function (data) {
            // create the option and append to Select2
            var option = new Option(data.name, data.id, true, true);
            usersSelect.append(option).trigger('change');

            // manually trigger the `select2:select` event
            usersSelect.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
        });

    }

});
</script>
@endpush

@push('css')
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>   
@endpush