<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tindakan;
use App\Models\TindakanBHP;
use App\Models\Barang;

class TindakanBHPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            $isExist = TindakanBHP::where('barang_id', $request->barang_id)
            ->where('tindakan_id', $request->tindakan_id)->first();

            if (isset($isExist)) {
                $isExist->jumlah += $request->jumlah;
                $isExist->save();
            } else {
                //return $input;
                TindakanBHP::create($input);
            }

            $data['listBhp'] = TindakanBHP::where('tindakan_id', $request->tindakan_id)->get();
            return view('tindakan.ajax-bhp', $data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data['listBhp'] = TindakanBHP::where('tindakan_id', $id)->get();
        return view('tindakan.ajax-bhp', $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = TindakanBHP::findOrFail($id);
            $data->delete();
            return response()->json(['success' => true]);
        }
    }
}
