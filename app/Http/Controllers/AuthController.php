<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        $setting = Setting::first();

        return view('admin.auth.login', compact('setting'));
    }

    // Menampilkan halaman register
    public function register()
    {
        $setting = Setting::first();

        return view('admin.auth.register', compact('setting'));
    }

    // Proses login
    public function proses_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $username = $request->get('username');
        $password = Hash::make($request->get('password'));
        if (Auth::attempt($request->only('username', 'password'))) {
            $user = User::where('username', $username)->first();
            if ($user->role == 'Admin' || $user->role == 'Pegawai') {
                Auth::guard('admin')->loginUsingId($user->id);
                return redirect()->route('admin.dashboard')->with('berhasil', 'Selamat datang '.Auth::user()->name);
            } elseif ($user->role == 'Pelanggan') {
                Auth::guard('pelanggan')->loginUsingId($user->id);
                return redirect()->route('home')->with('berhasil', 'Selamat datang '.Auth::user()->name);
            }
        } else {
            return back()->with('gagal', 'Data yang dimasukkan tidak sesuai.');
        }
    }

    // Proses Register
    public function proses_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'jns_kelamin' => 'required',
            'tmpt_lahir' => 'required',
            'tgl_lahir' => 'required',
            'email' => 'required|unique:users,email|email',
            'no_telp' => 'required|unique:profiles,no_telp',
            'alamat' => 'required',
            'image' => 'mimes:png,jpg,jpeg,svg,webp',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8|confirmed',
        ],
        [
            'required' => ':attribute wajib diisi !!',
            'unique' => ':attribute sudah ada !!',
            'confirmed' => ':attribute tidak sama dengan yang dimasukkan !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = new User;
        $user->name = $request->get('nama_lengkap');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->password = Hash::make($request->get('password'));
        $user->role = 'Pelanggan';
        $user->save();

        $user_id = $user->id;

        if ($request->image <> '') {
            $image = $request->file('gambar_1');
            $namaimage = 'Profile-'.str_replace(' ', '-', $request->get('nama_lengkap')).Str::random(5).'.'.$image->extension();
            $image->move(public_path('images/'), $namaimage);
            $gambarNama1 = 'images/'.$namaimage;
        } else {
            $gambarNama1 = null;
        }

        $profile = new Profile;
        $profile->user_id = $user_id;
        $profile->no_telp = $request->get('no_telp');
        $profile->jns_kelamin = $request->get('jns_kelamin');
        $profile->tmpt_lahir = $request->get('tmpt_lahir');
        $profile->tgl_lahir = $request->get('tgl_lahir');
        $profile->alamat = $request->get('alamat');
        $profile->foto = $gambarNama1;
        $profile->save();

        return redirect()->route('login')->with('berhasil', 'Pendaftaran berhasil.');
    }

    // Proses logout
    public function logout($slug)
    {
        if ($slug == 'Admin' || $slug == 'Pegawai') {
            Auth::guard('admin')->logout();
        } elseif ($slug == 'Pelanggan') {
            Auth::guard('pelanggan')->logout();
        }
        return redirect()->route('login')->with('berhasil', 'Berhasil keluar akun.');
    }
}
