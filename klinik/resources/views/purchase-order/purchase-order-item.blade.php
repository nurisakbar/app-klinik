<table class="table table-bordered" id="ajax-po-item">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Satuan</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Harga (PO)</th>
            <th scope="col">Diskon (%)</th>
            <th scope="col">Harga Diskon</th>
            <th scope="col">Subtotal</th>
            @if(isset($purchase_order))
                @if($purchase_order->status_po=='approve_by_pimpinan')
                    <th>Catatan</th>
                    <th>Status</th>
                @endif
            @endif
            @if(isset($purchase_order))
                @if(!in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan']))
                    <th scope="col" width="30">Action</th>
                @endif
            @endif
        </tr>
    </thead>
    <tbody>
        <?php $total = 0;  ?>
        @foreach($purchase_order_detail as $row)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $row->barang->nama_barang }}</td>
            <td>{{ $row->satuan->satuan??'-' }}</td>
            <td>
                @if(isset($purchase_order))
                    @if(in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan']))
                        {{ $row->qty }}
                    @else
                        <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'qty'>
                            {{ $row->qty }}
                        </a>
                    @endif
                @else
                    <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'qty'>
                        {{ $row->qty }}
                    </a>
                @endif
            </td>
            <td>
                @if(isset($purchase_order))
                    @if(in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan']))
                            {{ rupiah($row->harga) }}
                    @else
                        <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'harga'>
                            {{ rupiah($row->harga) }}
                        </a>
                    @endif
                @else
                    <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'harga'>
                        {{ rupiah($row->harga)}}
                    </a>
                @endif
            </td>
            <?php
            $harga_diskon = ($row->diskon/100)*$row->harga;
            ?>
            <td>{{ rupiah($row->diskon)}} % ( Rp. {{ $harga_diskon }} )</td>

            <td>{{ rupiah($row->harga-$harga_diskon)}}</td>
            <td>{{ rupiah(($row->harga-$harga_diskon)*$row->qty) }}</td>
            @if(isset($purchase_order))
                @if($purchase_order->status_po=='approve_by_pimpinan')
                    <td>{{ $row->catatan}}</td>
                    <td>{{ $row->approval==1?'Disetujui':'Ditolak'}}</td>
                @endif
            @endif
            @if(isset($purchase_order))
                @if(!in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan']))
                <td>
                    <button class="btn btn-danger btn-sm" onClick="hapus_barang({{ $row->id }})">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
                @endif
            @else
                <td>
                    <button class="btn btn-danger btn-sm" onClick="hapus_barang({{ $row->id }})">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            @endif
        </tr>
        <?php
        if(isset($purchase_order))
        {
            $total += ($row->harga-$harga_diskon) * $row->qty;
        }
        else{
            $total += ($row->harga-$harga_diskon) * $row->qty;
        }
        
        ?>
        @endforeach
    </tbody>
    <tr>
        <td></td>
        <td colspan="4" class="text-right">Subtotal</td>
        <th colspan="3" class="text-right">
            {{ $total }}
        </th>
    </tr>
    <?php
    if(isset($purchase_order))
    {
        $diskon = $purchase_order->diskon;
    }
    else{
        $diskon = 0;
    }
    
    ?>
    <tr>
        <td></td>
        <td colspan="4" class="text-right">Diskon</td>
        <th colspan="3" class="text-right">
            <input type="text" name="diskon" required="required" placeholder="Diskon" value="0" onKeyUp="copyDiskon()" class="form-control disc text-right" >
            <input value="{{ $total }}" type="hidden" id="jumlah_total">
        </th>
    </tr>
    <tfoot>
        <tr>
            <td></td>
            <td colspan="4" class="text-right">Total</td>
            <th colspan="3" class="text-right txt_diskon">{{ rupiah($total-$diskon) }}</th>
        </tr>
    </tfoot>
</table>