<div class="form-group">
    <label class="col-sm-2 control-label">Nama pegawai</label>
    <div class="col-sm-10">
        {!! Form::hidden('pegawai_id', $pegawai->id, ['class'=>'form-control', 'readonly']) !!}
        {!! Form::text('', $pegawai->nama, ['class'=>'form-control', 'readonly']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Komponen Gaji</label>
    <div class="col-sm-10">
        {!! Form::select('komponen_gaji_id', $komponen_gaji ,null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jumlah</label>
    <div class="col-sm-10">
        {!! Form::number('jumlah', null, ['class'=>'form-control','Placeholder'=>'Rp. ']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-10">
        {!! Form::text('keterangan', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>

@if(Request::segment(3) == 'edit')
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="{{ url('pegawai/' . $pegawai->id .'?tab=komponen_gaji') }}" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>
@endif