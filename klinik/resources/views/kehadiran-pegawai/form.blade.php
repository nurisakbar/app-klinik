<div class="form-group">
    <label class="col-sm-2 control-label">Nama Pegawai</label>
    <div class="col-sm-4">
        {!! Form::select('pegawai_id', $pegawai, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jadwal Shift</label>
    <div class="col-sm-4">
        {!! Form::select('shift_id', $shift, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jam Masuk & Pulang</label>
    <div class="col-sm-2">
        {!! Form::time('jam_masuk', null, ['class'=>'form-control','Placeholder'=>'Ex: 08:00']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::time('jam_keluar', null, ['class'=>'form-control','Placeholder'=>'Ex: 17:00']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tanggal & Status Kehadiran</label>
    <div class="col-sm-2">
        {!! Form::date('tanggal', null, ['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::select('status', $status, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/kehadiran-pegawai" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>