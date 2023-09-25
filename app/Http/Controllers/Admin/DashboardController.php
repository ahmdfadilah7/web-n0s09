<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $setting = Setting::first();
        $produk = Produk::orderBy('id', 'DESC')->get();
        $jumlahpenjualan = Invoice::where('status', 4)
            ->count();
        $jumlahpesanan = Invoice::where('status', '<>', 0)
            ->count();
        $totalpenjualan = Invoice::where('status', 4)
            ->get();
        $belumbayar = Invoice::where('status', 1)
            ->where('konfirmasi', 0)->count();
        $menunggukonfirmasi = Invoice::where('status', 1)
            ->where('konfirmasi', 1)->count();
        $diproses = Invoice::where('status', 2)
            ->count();
        $dikirim = Invoice::where('status', 3)
            ->count();
        $selesai = Invoice::where('status', 4)
            ->count();
        $batal = Invoice::where('status', 5)
            ->count();
        $pembelian = Pembelian::get();
        
        return view('admin.dashboard.index', compact(
                'setting', 
                'produk', 
                'jumlahpenjualan', 
                'jumlahpesanan', 
                'totalpenjualan', 
                'belumbayar', 
                'menunggukonfirmasi', 
                'diproses', 
                'dikirim', 
                'selesai', 
                'batal',
                'pembelian',
            ));
    }
}
