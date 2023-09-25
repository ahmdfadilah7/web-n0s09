<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    // Menampilkan halaman profile
    public function index()
    {
        $setting = Setting::first();
        $invoice = Invoice::where('status', 0)->where('user_id', Auth::guard('pelanggan')->user()->id)->first();
        if ($invoice <> '') {
            $transaksi = Transaksi::where('invoice_id', $invoice->id)->count();
        } else {
            $transaksi = 0;
        }

        return view('profile.index', compact('setting', 'invoice', 'transaksi'));
    }

    // Menampilkan halaman edit profile
    public function edit($id)
    {
        $setting = Setting::first();
        $invoice = Invoice::where('status', 0)->where('user_id', Auth::guard('pelanggan')->user()->id)->first();
        if ($invoice <> '') {
            $transaksi = Transaksi::where('invoice_id', $invoice->id)->count();
        } else {
            $transaksi = 0;
        }

        return view('profile.edit', compact('setting', 'invoice', 'transaksi'));
    }

    // Proses mengupdate profile
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'foto' => 'mimes:jpeg,jpg,png,svg,webp',
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        if ($request->foto <> '') {
            $gambar = $request->file('foto');
            $namagambar = 'Profile-'.str_replace(' ', '-', $request->get('nama_lengkap')).Str::random(5).'.'.$gambar->extension();
            $gambar->move(public_path('images/'), $namagambar);
            $gambarNama = 'images/'.$namagambar;
        }

        $profile = Profile::where('user_id', $id)->first();
        $profile->no_telp = $request->get('no_telp');
        $profile->tmpt_lahir = $request->get('tempat_lahir');
        $profile->tgl_lahir = $request->get('tanggal_lahir');
        $profile->jns_kelamin = $request->get('jenis_kelamin');
        $profile->alamat = $request->get('alamat');
        if ($request->foto <> '') {
            $profile->foto = $gambarNama;
        }
        $profile->save();

        $user = User::find($id);
        $user->name = $request->get('nama_lengkap');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        if ($request->password <> '') {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        return redirect()->route('profile')->with('berhasil', 'Berhasil mengupdate profile.');

    }
}
