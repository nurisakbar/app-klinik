<table class="table table-bordered form-racik-{{$table_item}}">
    <tr>
      <th>Jumlah Kemasan</th>
      <th>Jenis Kemasan</th>
      <th>Aturan Pakai  
      <button type="button" class="btn btn-sm btn-danger" style="float: right" onClick="hapus_obat_racik_form({{$table_item}})">
        <i class="fa fa-trash" aria-hidden="true"></i>
      </button>
     
    </th>
    </tr>
    <tr>
      <td>
        {{ Form::text('jumlah_kemasan['.$id.'][]',null,['class'=>'form-control','placeholder'=>'Jumlah Kemasan','required'=>'required'])}}
      </td>
      <td>
        {{ Form::select('jenis_kemasan['.$id.'][]',$satuan,null,['class'=>'form-control','placeholder'=>'Pilih','required'=>'required'])}}
      </td>
      <td>
        {{ Form::text('aturan_pakai['.$id.'][]',null,['class'=>'form-control','placeholder'=>'Aturan Pakai','required'=>'required'])}}
      </td>
    </tr>
    <tr>
      <th colspan="3">Komposisi Obat</th>
    </tr>
    <tr class="inner-{{$id}}">
      <td colspan="2">
        <select required="required" name="barang_id[{{$id}}][]" class='form-control barang_id_txt_{{$id}}' style="width:100%">
      </td>
      <td>
       
        <div class="row">
          <div class="col-md-5">
            {{ Form::text('jumlah['.$id.'][]',null,['class'=>'form-control','placeholder'=>'Jumlah','required'=>'required'])}}
          </div>
          <div class="col-md-5">
            <button type="button" class="btn btn-sm btn-danger" onClick="add_komposisi({{$id}})">
              <i class="fa fa-plus-square" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </td>
    </tr>
  </table>