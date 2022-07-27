<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\Poliklinik;
use App\Models\DokterPoliklinik;

class UserController extends Controller
{
    protected $user_role;
    protected $hari;

    public function __construct()
    {
        $this->user_role    = config('datareferensi.user_role');
        $this->hari         = config('datareferensi.hari');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = $request->role == 'user' ? ['administrator','apoteker','rekamedis', 'admin','akutansi', 'kasir', 'keuangan', 'hrd', 'bagian_gudang', 'admin_medis', 'poliklinik','pimpinan'] : [$request->role];
        if ($request->ajax()) {
            $user_role = $this->user_role;
            return DataTables::of(User::with('poliklinik')->whereIn('role', $role)->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'user/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/user/' . $row->id . '/edit?jabatan=' . $row->role . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/user/' . $row->id . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->addColumn('role', function ($row) use ($user_role) {
                    return $user_role[$row->role];
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
        $jabatan = $request->jabatan == 'user' ? 'index' : $request->jabatan;
        return view('user.' . $jabatan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['user_role']  = $this->user_role;
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['jabatan'] = $request->jabatan == 'dokter' ? 'dokter' : 'user';
        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $request['password']   = Hash::make($request->password);
        $user = User::create($request->all());
        if ($request->role == 'dokter') {
            DokterPoliklinik::create(['user_id' => $user->id, 'poliklinik_id' => $request->poliklinik_id]);
        }
        $role = in_array($request->role, ['administrator','rekamedis', 'kasir', 'hrd', 'keuangan', 'admin_medis', 'bagian_gudang', 'pimpinan', 'bagian_pendaftaran', 'poliklinik','apoteker']) ? 'user' : $request->role;
        return redirect(route('user.index', ['jabatan' => $role]))->with('message', 'Pengguna Bernama ' . $request->name . ' Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['hari']       = $this->hari;
        $data['user']       = User::findOrFail($id);
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        return view('user.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $data['user_role']  = $this->user_role;
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['user']       = User::findOrFail($id);
        $data['jabatan'] = $request->jabatan == 'dokter' ? 'dokter' : 'user';
        return view('user.edit', $data);
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
        $data = $request->all();
        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = $request->except('password');
        }

        $user = User::findOrFail($id);
        $user->update($data);
        $role = in_array($request->role, ['administrator', 'kasir','rekamedis', 'poliklinik','akutansi','apoteker']) ? 'user' : $request->role;
        return redirect(route('user.index', ['jabatan' => $role]))->with('message', 'Pengguna Bernama ' . $request->name . ' Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect(route('user.index', ['jabatan' => $user->role]))->with('message', 'Pengguna Bernama ' . $user->name . ' Berhasil Dihapus');
    }


    public function profile()
    {
        $data['user'] = User::findOrFail(Auth::user()->id);
        return view('user.profile', $data);
    }


    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $data = $request->all();
        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = $request->except('password');
        }
        $user->update($data);
        return redirect(route('user.profile'))->with('message', 'Profile Berhasil Di Update');
    }
}
