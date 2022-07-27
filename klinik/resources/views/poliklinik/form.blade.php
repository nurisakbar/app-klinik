<div class="form-group">
    <label class="col-sm-2 control-label">Kode Poli</label>
    <div class="col-sm-2">
        {!! Form::text('nomor_poli', null, ['class'=>'form-control','Placeholder'=>'Kode Poliklinik']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nama Poli</label>
    <div class="col-sm-10">
        {!! Form::text('nama', null, ['class'=>'form-control','Placeholder'=>'Nama Poliklinik']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-10">
        {!! Form::text('keterangan', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Status</label>
    <div class="col-sm-10">
        {!! Form::select('aktif',[1=>'Aktif',0=>'Tidak Aktif'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Unit</label>
    <div class="col-sm-10">
        {!! Form::select('jenis_unit',['poliklinik' =>'Poliklinik','laboratorium'=>'Laboratorium'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Depo Stock</label>
    <div class="col-sm-10">
        {!! Form::select('unit_stock_id',$unit_stock, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/poliklinik" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>