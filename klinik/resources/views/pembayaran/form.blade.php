<div class="form-group">
    <label class="col-sm-4 control-label">Jumlah Bayar *</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon">Rp</span>
            {!! Form::number('jumlah_bayar', null, ['class'=>'form-control jumlah_bayar','onKeyUp'=>'hitung_kembalian()','Placeholder'=>'Jumlah Pembayaran']) !!}
            <input type="hidden" name="total_bayar" id="total_bayar">
          </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label">Biaya Tambahan * 
        
        </label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon">Rp</span>
            {!! Form::number('biaya_tambahan', 0, ['class'=>'form-control biaya_tambahan','onKeyUp'=>'hitung_kembalian()','Placeholder'=>'Biaya Tambahan']) !!}
          </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label">Kembalian</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon">Rp</span>
            {!! Form::number('kembalian', null, ['class'=>'form-control kembalian','Placeholder'=>'Kembalian']) !!}
          </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label">Metode Pembayaran</label>
    <div class="col-sm-8">
        {!! Form::select('metode_pembayaran', array_merge(['' => '--PILIH METODE PEMBAYARAN--'] + $metodePembayaran) ,null, ['class'=>'form-control','Placeholder'=>'Nama Obat']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label">Keterangan</label>
    <div class="col-sm-8">
        {!! Form::text('keterangan_pembayaran',null,['class'=>'form-control','Placeholder'=>'Keterangan Pembayaran'] ) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan Pembayaran</button>
        <a href="/pendaftaran" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>