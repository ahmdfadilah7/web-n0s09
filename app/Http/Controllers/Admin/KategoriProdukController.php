<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class KategoriProdukController extends Controller
{
    // Menampilkan halaman kategori produk
    public function index()
    {
        $setting = Setting::first();

        return view('admin.kategoriproduk.index', compact('setting'));
    }

    // Proses menampilkan data kategori produk dengan datatable
    public function listData()
    {
        $data = KategoriProduk::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gambar', function($row) {
                if ($row->gambar <> '') {
                    $img = '<img src="'.url($row->gambar).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.kategoriproduk.edit', $row->id).'" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                $btn .= '<a href="'.route('admin.kategoriproduk.delete', $row->id).'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'gambar'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman tambah kategori produk
    public function create()
    {
        $setting = Setting::first();

        return view('admin.kategoriproduk.add', compact('setting'));
    }

    // Proses tambah kategori produk
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
            'gambar' => 'required|mimes:png,jpg,jpeg,svg,webp'
        ], 
        [
            'required' => ':attribute wajib diisi !!',
            'mimes' => ':attribute format yang diizinkan :mimes'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $gambar = $request->file('gambar');
        $namagambar = 'Kategori-Produk-'.str_replace(' ', '-', $request->get('kategori')).Str::random(5).'.'.$gambar->extension();
        $gambar->move(public_path('images/'), $namagambar);
        $gambarNama = 'images/'.$namagambar;

        KategoriProduk::create([
            'kategori' => $request->get('kategori'),
            'gambar' => $gambarNama
        ]);

        return redirect()->route('admin.kategoriproduk')->with('berhasil', 'Berhasil menambahkan kategori produk baru.');
    }

    // Menampilkan halaman edit kategori produk
    public function edit($id)
    {
        $setting = Setting::first();
        $kategori = KategoriProduk::find($id);

        return view('admin.kategoriproduk.edit', compact('setting', 'kategori'));
    }

    // Proses mengupdate kategori produk
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
            'gambar' => 'mimes:png,jpg,jpeg,svg,webp'
        ], 
        [
            'required' => ':attribute wajib diisi !!',
            'mimes' => ':attribute format yang diizinkan :mimes'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        if ($request->gambar <> '') {
            $gambar = $request->file('gambar');
            $namagambar = 'Kategori-Produk-'.str_replace(' ', '-', $request->get('kategori')).Str::random(5).'.'.$gambar->extension();
            $gambar->move(public_path('images/'), $namagambar);
            $gambarNama = 'images/'.$namagambar;
        }

        $kategori = KategoriProduk::find($id);
        $kategori->kategori = $request->get('kategori');
        if ($request->gambar <> '') {
            File::delete($kategori->gambar);

            $kategori->gambar = $gambarNama;
        }
        $kategori->save();

        return redirect()->route('admin.kategoriproduk')->with('berhasil', 'Berhasil mengupdate kategori produk.');
    }

    // Proses menghapus kategori produk
    public function destroy($id)
    {
        $kategori = KategoriProduk::find($id);
        $kategori->delete();

        File::delete($kategori->gambar);

        return redirect()->route('admin.kategoriproduk')->with('berhasil', 'Berhasil menghapus kategori produk.');
    }
}
