<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    // Menampilkan halaman setting
    public function index()
    {
        $setting = Setting::first();

        return view('admin.setting.index', compact('setting'));
    }

    // Proses menampilkan data setting dengan datatables
    public function listData()
    {
        $data = Setting::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('logo', function($row) {
                if ($row->logo <> '') {
                    $img = '<img src="'.url($row->logo).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('favicon', function($row) {
                if ($row->favicon <> '') {
                    $img = '<img src="'.url($row->favicon).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('bg_login', function($row) {
                if ($row->favicon <> '') {
                    $img = '<img src="'.url($row->bg_login).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('bg_register', function($row) {
                if ($row->bg_register <> '') {
                    $img = '<img src="'.url($row->bg_register).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.setting.edit', $row->id).'" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'logo', 'favicon', 'bg_login', 'bg_register'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman edit setting
    public function edit($id)
    {
        $setting = Setting::find($id);

        return view('admin.setting.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_website' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'alamat' => 'required',
            'desk_singkat' => 'required',
            'judul_header' => 'required',
            'gambar_header' => 'required',
            'logo' => 'required|mimes:jpg,jpeg,png,svg,webp',
            'favicon' => 'required|mimes:jpg,jpeg,png,svg,webp',
            'bg_login' => 'required',
            'bg_register' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'instagram' => 'required',
            'youtube' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $logo = $request->file('logo');
        $namalogo = 'Logo-'.str_replace(' ', '-', $request->get('nama_website')).Str::random(5).'.'.$logo->extension();
        $logo->move(public_path('images/'), $namalogo);
        $logoNama = 'images/'.$namalogo;

        $favicon = $request->file('favicon');
        $namafavicon = 'Favicon-'.str_replace(' ', '-', $request->get('nama_website')).Str::random(5).'.'.$favicon->extension();
        $favicon->move(public_path('images/'), $namafavicon);
        $faviconNama = 'images/'.$namafavicon;

        $bg_login = $request->file('bg_login');
        $namabg_login = 'BG-Login-'.str_replace(' ', '-', $request->get('nama_website')).Str::random(5).'.'.$bg_login->extension();
        $bg_login->move(public_path('images/'), $namabg_login);
        $bg_loginNama = 'images/'.$namabg_login;

        $bg_register = $request->file('bg_register');
        $namabg_register = 'BG-Register-'.str_replace(' ', '-', $request->get('nama_website')).Str::random(5).'.'.$bg_register->extension();
        $bg_register->move(public_path('images/'), $namabg_register);
        $bg_registerNama = 'images/'.$namabg_register;

        $gambar_header = $request->file('gambar_header');
        $namagambar_header = 'Header-'.str_replace(' ', '-', $request->get('nama_website')).Str::random(5).'.'.$gambar_header->extension();
        $gambar_header->move(public_path('images/'), $namagambar_header);
        $gambar_headerNama = 'images/'.$namagambar_header;

        $setting = Setting::find($id);
        $setting->nama_website = $request->get('nama_website');
        $setting->email = $request->get('email');
        $setting->no_telp = $request->get('no_telp');
        $setting->alamat = $request->get('alamat');
        $setting->desk_singkat = $request->get('desk_singkat');
        $setting->judul_header = $request->get('judul_header');
        $setting->gambar_header = $gambar_headerNama;
        $setting->logo = $logoNama;
        $setting->favicon = $faviconNama;
        $setting->bg_login = $bg_loginNama;
        $setting->bg_register = $bg_registerNama;
        $setting->facebook = $request->get('facebook');
        $setting->twitter = $request->get('twitter');
        $setting->instagram = $request->get('instagram');
        $setting->youtube = $request->get('youtube');
        $setting->save();

        return redirect()->route('admin.setting')->with('berhasil', 'Berhasil mengupdate setting.');
    }
}
