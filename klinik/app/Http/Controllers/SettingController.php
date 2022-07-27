<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $data['setting']  = Setting::first();
        $data['deviceStatus'] = device('GET')->data;
        return view('setting', $data);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = str_replace(" ", "", $file->getClientOriginalName());
            $file->move("image", $fileName);
            $input['logo'] = $fileName;
        }
        $setting = Setting::first();
        $setting->update($input);
        return redirect(route('setting.index'))->with('message', 'Update Berhasil');
    }
}
