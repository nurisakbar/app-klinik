<div class="form-group">
    <label class="col-sm-2 control-label">Nama Supplier</label>
    <div class="col-sm-10">
        {!! Form::text('nama_supplier', null, ['class'=>'form-control','Placeholder'=>'Nama Supplier']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nomor Telpon</label>
    <div class="col-sm-10">
        {!! Form::text('nomor_telpon', null, ['class'=>'form-control','Placeholder'=>'Nomor Telpon']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Alamat</label>
    <div class="col-sm-10">
        {!! Form::text('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/supplier" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>