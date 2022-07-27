<div class="form-group">
    <label class="col-sm-2 control-label">Nama Perusahaan</label>
    <div class="col-sm-10">
        {!! Form::text('nama_perusahaan', null, ['class'=>'form-control','Placeholder'=>'Nama']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/perusahaan-asuransi" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>