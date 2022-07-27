<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\JadwalPraktek;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'dokter') {
            session(['user_name' => Auth::user()->name]);
            session(['user_id' => Auth::user()->id]);
            $checkJadwalTugas = JadwalPraktek::where('user_id', Auth::user()->id)
                                ->where('hari', date('l'))->first();
            $user = \App\User::where('poliklinik_id', $checkJadwalTugas->poliklinik_id)->where('role', 'poliklinik')->first();
            if (Auth::loginUsingId($user->id, true)) {
            }
        }
        return view('home');
    }
}
