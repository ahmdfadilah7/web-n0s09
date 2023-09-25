<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // Menampilkan halaman shop
    public function index()
    {
        $setting = Setting::first();
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
        $kategori = KategoriProduk::get();
        $produk = Produk::orderBy('id', 'DESC')->simplePaginate(9);

        return view('shop.index', compact('setting', 'kategori', 'produk', 'transaksi'));
    }

    // Menampilkan halaman shop dengan kategori
    public function kategori($slug)
    {
        $setting = Setting::first();
        $kategori = KategoriProduk::get();
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
        if ($slug == 'semua') {
            $produk = Produk::select('produks.*', 'kategori_produks.kategori')
                ->join('kategori_produks', 'produks.kategoriproduk_id', 'kategori_produks.id')
                ->orderBy('produks.id', 'DESC')
                ->simplePaginate(9);
        } else {
            $slug = str_replace('-', ' ', $slug);
            $produk = Produk::select('produks.*', 'kategori_produks.kategori')
                ->join('kategori_produks', 'produks.kategoriproduk_id', 'kategori_produks.id')
                ->where('kategori', $slug)->orderBy('produks.id', 'DESC')
                ->simplePaginate(9);
        }

        return view('shop.index', compact('setting', 'kategori', 'produk', 'transaksi'));
    }

    // Menampilkan halaman shop detail
    public function detail($slug)
    {
        $setting = Setting::first();
        $kategori = KategoriProduk::get();
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

        $produk = Produk::select('produks.*', 'kategori_produks.kategori')->join('kategori_produks', 'produks.kategoriproduk_id', 'kategori_produks.id')->where('slug', $slug)->first();
        $produk_lain = Produk::where('id', '<>', $produk->id)->orderBy('id', 'DESC')->limit(4)->get();

        return view('shop.detail', compact('setting', 'kategori', 'produk', 'produk_lain', 'transaksi'));
    }
}
