<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AllHelper;
use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    // Menampilkan halaman produk
    public function index()
    {
        $setting = Setting::first();

        return view('admin.produk.index', compact('setting'));
    }

    // Proses menampilkan data produk dengan datatable
    public function listData()
    {
        $data = Produk::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('harga_modal', function($row) {
                $hrg = AllHelper::rupiah($row->harga_modal);
                return $hrg;
            })
            ->addColumn('harga_jual', function($row) {
                $hrg = AllHelper::rupiah($row->harga_jual);
                return $hrg;
            })
            ->addColumn('gambar', function($row) {
                if ($row->gambar <> '') {
                    $img = '<img src="'.url($row->gambar).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('gambar_1', function($row) {
                if ($row->gambar_1 <> '') {
                    $img = '<img src="'.url($row->gambar_1).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('gambar_2', function($row) {
                if ($row->gambar_2 <> '') {
                    $img = '<img src="'.url($row->gambar_2).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('gambar_3', function($row) {
                if ($row->gambar_3 <> '') {
                    $img = '<img src="'.url($row->gambar_3).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('gambar_4', function($row) {
                if ($row->gambar_4 <> '') {
                    $img = '<img src="'.url($row->gambar_4).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.produk.edit', $row->id).'" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                $btn .= '<a href="'.route('admin.produk.delete', $row->id).'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'gambar', 'gambar_1', 'gambar_2', 'gambar_3', 'gambar_4', 'harga_modal', 'harga_jual'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman tambah produk
    public function create()
    {
        $setting = Setting::first();
        $kategori = KategoriProduk::get();

        return view('admin.produk.add', compact('setting', 'kategori'));
    }

    // Proses tambah produk
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'harga_modal' => 'required',
            'harga_jual' => 'required',
            'gambar' => 'required|mimes:png,jpg,jpeg,svg,webp',
            'gambar_1' => 'mimes:png,jpg,jpeg,svg,webp',
            'gambar_2' => 'mimes:png,jpg,jpeg,svg,webp',
            'gambar_3' => 'mimes:png,jpg,jpeg,svg,webp',
            'gambar_4' => 'mimes:png,jpg,jpeg,svg,webp',
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
        $namagambar = 'Produk-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar->extension();
        $gambar->move(public_path('images/'), $namagambar);
        $gambarNama = 'images/'.$namagambar;

        if ($request->gambar_1 <> '') {
            $gambar1 = $request->file('gambar_1');
            $namagambar1 = 'Produk-1-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar1->extension();
            $gambar1->move(public_path('images/'), $namagambar1);
            $gambarNama1 = 'images/'.$namagambar1;
        } else {
            $gambarNama1 = null;
        }

        if ($request->gambar_2 <> '') {
            $gambar2 = $request->file('gambar_2');
            $namagambar2 = 'Produk-2-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar2->extension();
            $gambar2->move(public_path('images/'), $namagambar2);
            $gambarNama2 = 'images/'.$namagambar2;
        } else {
            $gambarNama2 = null;
        }

        if ($request->gambar_3 <> '') {
            $gambar3 = $request->file('gambar_3');
            $namagambar3 = 'Produk-3-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar3->extension();
            $gambar3->move(public_path('images/'), $namagambar3);
            $gambarNama3 = 'images/'.$namagambar3;
        } else {
            $gambarNama3 = null;
        }

        if ($request->gambar_4 <> '') {
            $gambar4 = $request->file('gambar_4');
            $namagambar4 = 'Produk-4-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar4->extension();
            $gambar4->move(public_path('images/'), $namagambar4);
            $gambarNama4 = 'images/'.$namagambar4;
        } else {
            $gambarNama4 = null;
        }

        Produk::create([
            'nama' => $request->get('nama'),
            'slug' => strtolower(str_replace(' ', '-', $request->get('nama'))),
            'deskripsi' => $request->get('deskripsi'),
            'harga_modal' => str_replace(',', '', $request->get('harga_modal')),
            'harga_jual' => str_replace(',', '', $request->get('harga_jual')),
            'kategoriproduk_id' => $request->get('kategori'),
            'gambar' => $gambarNama,
            'gambar_1' => $gambarNama1,
            'gambar_2' => $gambarNama2,
            'gambar_3' => $gambarNama3,
            'gambar_4' => $gambarNama4,
        ]);

        return redirect()->route('admin.produk')->with('berhasil', 'Berhasil menambahkan produk baru.');
    }

    // Menampilkan halaman edit produk
    public function edit($id)
    {
        $setting = Setting::first();
        $kategori = KategoriProduk::get();
        $produk = Produk::find($id);

        return view('admin.produk.edit', compact('setting', 'kategori', 'produk'));
    }

    // Proses mengupdate produk
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'harga_modal' => 'required',
            'harga_jual' => 'required',
            'gambar' => 'mimes:png,jpg,jpeg,svg,webp',
            'gambar_1' => 'mimes:png,jpg,jpeg,svg,webp',
            'gambar_2' => 'mimes:png,jpg,jpeg,svg,webp',
            'gambar_3' => 'mimes:png,jpg,jpeg,svg,webp',
            'gambar_4' => 'mimes:png,jpg,jpeg,svg,webp',
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
            $namagambar = 'Produk-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar->extension();
            $gambar->move(public_path('images/'), $namagambar);
            $gambarNama = 'images/'.$namagambar;
        }

        if ($request->gambar_1 <> '') {
            $gambar1 = $request->file('gambar_1');
            $namagambar1 = 'Produk-1-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar1->extension();
            $gambar1->move(public_path('images/'), $namagambar1);
            $gambarNama1 = 'images/'.$namagambar1;
        }

        if ($request->gambar_2 <> '') {
            $gambar2 = $request->file('gambar_2');
            $namagambar2 = 'Produk-2-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar2->extension();
            $gambar2->move(public_path('images/'), $namagambar2);
            $gambarNama2 = 'images/'.$namagambar2;
        }

        if ($request->gambar_3 <> '') {
            $gambar3 = $request->file('gambar_3');
            $namagambar3 = 'Produk-3-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar3->extension();
            $gambar3->move(public_path('images/'), $namagambar3);
            $gambarNama3 = 'images/'.$namagambar3;
        }

        if ($request->gambar_4 <> '') {
            $gambar4 = $request->file('gambar_4');
            $namagambar4 = 'Produk-4-'.str_replace(' ', '-', $request->get('nama')).Str::random(5).'.'.$gambar4->extension();
            $gambar4->move(public_path('images/'), $namagambar4);
            $gambarNama4 = 'images/'.$namagambar4;
        }

        $produk = Produk::find($id);
        $produk->nama = $request->get('nama');
        $produk->slug = strtolower(str_replace(' ', '-', $request->get('nama')));
        $produk->deskripsi = $request->get('deskripsi');
        $produk->harga_modal = str_replace(',', '', $request->get('harga_modal'));
        $produk->harga_jual = str_replace(',', '', $request->get('harga_jual'));
        $produk->kategoriproduk_id = $request->get('kategori');
        if ($request->gambar <> '') {
            File::delete($produk->gambar);

            $produk->gambar = $gambarNama;
        }
        if ($request->gambar_1 <> '') {
            File::delete($produk->gambar_1);

            $produk->gambar_1 = $gambarNama1;
        }
        if ($request->gambar_2 <> '') {
            File::delete($produk->gambar_2);

            $produk->gambar_2 = $gambarNama2;
        }
        if ($request->gambar_3 <> '') {
            File::delete($produk->gambar_3);

            $produk->gambar_3 = $gambarNama3;
        }
        if ($request->gambar_4 <> '') {
            File::delete($produk->gambar_4);

            $produk->gambar_4 = $gambarNama4;
        }
        $produk->save();

        return redirect()->route('admin.produk')->with('berhasil', 'Berhasil mengupdate produk.');
    }

    // Proses menghapus produk
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        File::delete($produk->gambar);
        if ($produk->gambar_1 <> '') {
            File::delete($produk->gambar_1);
        }
        if ($produk->gambar_2 <> '') {
            File::delete($produk->gambar_2);
        }
        if ($produk->gambar_3 <> '') {
            File::delete($produk->gambar_3);
        }
        if ($produk->gambar_4 <> '') {
            File::delete($produk->gambar_4);
        }

        return redirect()->route('admin.produk')->with('berhasil', 'Berhasil menghapus produk.');
    }
}
