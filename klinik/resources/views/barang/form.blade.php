<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Barang</label>
    <div class="col-sm-5">
        {!! Form::select('jenis_barang',$jenis_barang, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kode Barang</label>
    <div class="col-sm-2">
        {!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'Kode Barang']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Nama Barang</label>
    <div class="col-sm-6">
        {!! Form::text('nama_barang', null, ['class'=>'form-control','Placeholder'=>'Nama Barang']) !!}
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-8">
        {!! Form::text('keterangan', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Satuan Terbesar</label>
    <div class="col-sm-3">
        {!! Form::text('jumlah_satuan_terbesar', null, ['class'=>'form-control','Placeholder'=>'Jumlah Satuan Terbesar']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::select('satuan_terbesar_id',$satuan, null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Satuan Terkecil</label>
    <div class="col-sm-3">
        {!! Form::text('jumlah_satuan_terkecil', null, ['class'=>'form-control','Placeholder'=>'Jumlah Satuan Terkecil']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::select('satuan_terkecil_id',$satuan, null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Kategori</label>
    <div class="col-sm-5">
        {!! Form::select('kategori_id',$kategori, null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Pedagang Besar Farmasi</label>
    <div class="col-sm-5">
        {!! Form::select('pbf_id',$pbf, null, ['class'=>'form-control']) !!}
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Harga & Margin</label>
    <div class="col-sm-2">
        {!! Form::text('harga', null, ['class'=>'form-control','Placeholder'=>'Harga']) !!}
    </div>
    <div class="col-sm-2">
        <div class="input-group">
            {!! Form::text('margin', null, ['class'=>'form-control','Placeholder'=>'margin']) !!}
            <span class="input-group-addon">%</span>
          </div>
        
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Pelayanan</label>
    <div class="col-sm-2">
        {!! Form::select('pelayanan',['umum'=>'Umum','bpjs'=>'BPJS'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Status Aktif</label>
    <div class="col-sm-2">
        {!! Form::select('aktif',[1=>'Aktif',0=>'Tidak Aktif'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/barang" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>