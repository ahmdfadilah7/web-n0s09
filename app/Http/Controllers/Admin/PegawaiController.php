<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    // Menampilkan halaman pegawai
    public function index()
    {
        $setting = Setting::first();

        return view('admin.pegawai.index', compact('setting'));
    }

    // Proses menampilkan data pegawai dengan datatables
    public function listData()
    {
        $data = User::where('role', 'Pegawai');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pegawai.edit', $row->id).'" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                $btn .= '<a href="'.route('admin.pegawai.delete', $row->id).'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman tambah pegawai
    public function create()
    {
        $setting = Setting::first();

        return view('admin.pegawai.add', compact('setting'));
    }

    // Proses menambahkan pegawai
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pegawai' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8'
        ],
        [
            'required' => ':attribute wajib diisi !!',
            'unique' => ':attribute sudah ada !!',
            'min' => ':attribute minimal :min karakter !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        User::create([
            'name' => $request->get('nama_pegawai'),
            'email' => $request->get('email'),
            'role' => 'Pegawai',
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
        ]);

        return redirect()->route('admin.pegawai')->with('berhasil', 'Berhasil menambahkan pegawai baru.');
    }

    // Menampilkan halaman edit pegawai
    public function edit($id)
    {
        $setting = Setting::first();
        $user = User::find($id);

        return view('admin.pegawai.edit', compact('setting', 'user'));
    }

    // Proses mengupdate pegawai
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pegawai' => 'required',
            'email' => 'required',
            'username' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi !!',
            'unique' => ':attribute sudah ada !!',
            'min' => ':attribute minimal :min karakter !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $user = User::find($id);
        $user->name = $request->get('nama_pegawai');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        if ($request->password <> '') {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        return redirect()->route('admin.pegawai')->with('berhasil', 'Berhasil mengupdate pegawai.');
    }

    // Proses menghapus pegawai
    public function destroy($id)
    {
        $user = User::where('role', 'Pegawai')
            ->find($id);
        $user->delete();

        return redirect()->route('admin.pegawai')->with('berhasil', 'Berhasil menghapus pegawai.');
    }
}
