<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Invoice;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Menampilkan halaman home
    public function index()
    {
        $setting = Setting::first();
        $kategori = KategoriProduk::get();
        $produk = Produk::orderBy('id', 'DESC')->limit(8)->get();
        if (Auth::guard('pelanggan')->user() <> '') {
            $invoice = Invoice::where('status', 0)->where('user_id', Auth::guard('pelanggan')->user()->id)->first();
        } else {
            $invoice = '';
        }
        if ($invoice <> '') {
            $transaksi = Transaksi::where('invoice_id', $invoice->id)->count();
        } else {
            $transaksi = 0;
        }

        return view('home.index', compact('setting', 'kategori', 'produk', 'transaksi'));
    }

    public function get_produk($id)
    {
        $produk = Produk::find($id);

        $data = [
            'id_produk' => $produk->id,
            'nama_produk' => $produk->nama,
            'gambar_produk' => url($produk->gambar),
            'deskripsi_produk' => substr($produk->deskripsi, 3, 300).'...',
            'harga_barang' => AllHelper::rupiah($produk->harga_jual),
            'harga_produk' => $produk->harga_jual,
            'stok_produk' => $produk->stok
        ];

        return json_encode($data);
    }
}
