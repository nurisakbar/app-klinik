<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrderDetail;
use App\Models\Barang;

class PurchaseOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['purchase_order_detail'] = PurchaseOrderDetail::where('purchase_order_id', null)->get();
        return view('purchase-order.purchase-order-item', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $isExist = PurchaseOrderDetail::where('barang_id', $request->barang_id)
            ->where('purchase_order_id', null)->first();

            if (isset($isExist)) {
                $isExist->update($input);
            } else {
                PurchaseOrderDetail::create($input);
            }

            return response()->json(['success' => true]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $isExist = PurchaseOrderDetail::where('barang_id', $request->barang_id)
            ->where('purchase_order_id', $id)->first();

            $input['purchase_order_id'] = $id;

            if (isset($isExist)) {
                $isExist->update($input);
            } else {
                PurchaseOrderDetail::create($input);
            }

            return response()->json(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseOrderDetail::findOrFail($id);
            $data->delete();
            return response()->json(['success' => true]);
        }
    }
}
