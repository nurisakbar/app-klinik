<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function getQRCode(Request $request)
    {
        // Get device name
        $deviceName = $request->device;

        // Check type request is login or register
        if ($request->login != null) {
            try {
                $device = device('GET', $deviceName);
            } catch (\Throwable $th) {
                \Session::flash('messageErr', 'Device tidak ditemukan!');
                return redirect('setting');
            }
        } else {
            try {
                $device = device('POST', $deviceName);
            } catch (\Throwable $th) {
                \Session::flash('messageErr', 'Device sudah terdaftar atau kesalahan dalam input!');
                return redirect('setting');
            }
        }

        // Check status device on API service
        if ($device->status == 'disconnected') {
            $qrcode = getQRCode($device->id);
            $link = $qrcode->image_url;
            return view('preview_qrcode', compact('link'));
        } else {
            \Session::flash('success', 'Device sudah terkoneksi!');
            return redirect('setting');
        }
    }
}
