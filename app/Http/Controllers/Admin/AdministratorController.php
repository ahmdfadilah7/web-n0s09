<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdministratorController extends Controller
{
    // Menampilkan halaman administrator
    public function index()
    {
        $setting = Setting::first();

        return view('admin.administrator.index', compact('setting'));
    }

    // Proses menampilkan data administrator dengan datatables
    public function listData()
    {
        $data = User::where('role', 'Admin');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.administrator.edit', $row->id).'" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                if ($row->id <> Auth::guard('admin')->user()->id) {
                    $btn .= '<a href="'.route('admin.administrator.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </a>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman tambah administrator
    public function create()
    {
        $setting = Setting::first();

        return view('admin.administrator.add', compact('setting'));
    }

    // Proses menambahkan administrator
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_administrator' => 'required',
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
            'name' => $request->get('nama_administrator'),
            'email' => $request->get('email'),
            'role' => 'Admin',
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
        ]);

        return redirect()->route('admin.administrator')->with('berhasil', 'Berhasil menambahkan administrator baru.');
    }

    // Menampilkan halaman edit administrator
    public function edit($id)
    {
        $setting = Setting::first();
        $user = User::find($id);

        return view('admin.administrator.edit', compact('setting', 'user'));
    }

    // Proses mengupdate administrator
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_administrator' => 'required',
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
        $user->name = $request->get('nama_administrator');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        if ($request->password <> '') {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        return redirect()->route('admin.administrator')->with('berhasil', 'Berhasil mengupdate administrator.');
    }

    // Proses menghapus administrator
    public function destroy($id)
    {
        $user = User::where('role', 'Admin')
            ->find($id);
        $user->delete();

        return redirect()->route('admin.administrator')->with('berhasil', 'Berhasil menghapus administrator.');
    }
}
