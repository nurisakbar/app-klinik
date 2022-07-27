<tr class="komposisi-{{$komposisi_item}}">
    <td colspan="2">
      <select required="required" name="barang_id[{{$id}}][]" class='form-control barang_id_txt_{{$id}}' style="width:100%">
    </td>
    <td>
     
      <div class="row">
        <div class="col-md-5">
          {{ Form::text('jumlah['.$id.'][]',null,['class'=>'form-control','placeholder'=>'Jumlah','required'=>'required'])}}
        </div>
        <div class="col-md-5">
          <button type="button" class="btn btn-sm btn-danger" onClick="hapus_komposisi({{$komposisi_item}})">
            <i class="fa fa-trash" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </td>
  </tr>