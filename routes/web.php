<?php

use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JasaKirimController;
use App\Http\Controllers\Admin\KategoriProdukController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\RekeningController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('get_produk/{id}', [HomeController::class, 'get_produk'])->name('get_produk');
Route::get('shop', [ShopController::class, 'index'])->name('shop');
Route::get('shop/kategori/{slug}', [ShopController::class, 'kategori'])->name('shop.kategori');
Route::get('shop/detail/{slug}', [ShopController::class, 'detail'])->name('shop.detail');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proseslogin', [AuthController::class, 'proses_login'])->name('prosesLogin');
Route::post('prosesregister', [AuthController::class, 'proses_register'])->name('prosesRegister');
Route::get('logout/{slug}', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth:pelanggan', 'role:Pelanggan']], function() {

    Route::get('keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('keranjang/store', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::get('keranjang/checkout/{kode_invoice}', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::get('keranjang/pengiriman/{pengiriman}/{kode_invoice}', [KeranjangController::class, 'pengiriman'])->name('keranjang.pengiriman');
    Route::get('keranjang/invoice/{kode_invoice}', [KeranjangController::class, 'invoice'])->name('keranjang.invoice');
    Route::post('keranjang/prosesInvoice/{kode_invoice}', [KeranjangController::class, 'proses_invoice'])->name('keranjang.prosesInvoice');
    Route::get('keranjang/bayar/{kode_invoice}', [KeranjangController::class, 'bayar'])->name('keranjang.bayar');
    Route::post('keranjang/prosesPembayaran', [KeranjangController::class, 'proses_pembayaran'])->name('keranjang.prosesPembayaran');
    Route::post('keranjang/updateJumlah/{id}', [KeranjangController::class, 'update_jumlah'])->name('keranjang.updatejumlah');
    Route::get('keranjang/delete/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.delete');

    Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::get('pesanan/invoice/{kode_invoice}', [PesananController::class, 'invoice'])->name('pesanan.invoice');
    Route::get('pesanan/getListBelumBayar', [PesananController::class, 'listBelumBayar'])->name('pesanan.listbelumbayar');
    Route::get('pesanan/getListMenungguKonfirmasi', [PesananController::class, 'listMenungguKonfirmasi'])->name('pesanan.listmenunggukonfirmasi');
    Route::get('pesanan/getListDiproses', [PesananController::class, 'listDiproses'])->name('pesanan.listdiproses');
    Route::get('pesanan/getListDikirim', [PesananController::class, 'listDikirim'])->name('pesanan.listdikirim');
    Route::get('pesanan/getListSelesai', [PesananController::class, 'listSelesai'])->name('pesanan.listselesai');
    Route::get('pesanan/getListBatal', [PesananController::class, 'listBatal'])->name('pesanan.listbatal');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    
});

Route::group(['middleware' => ['auth:admin', 'role:Admin,Pegawai']], function() {

    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/pesanan', [AdminPesananController::class, 'index'])->name('admin.pesanan');
    Route::get('admin/pesanan/add', [AdminPesananController::class, 'create'])->name('admin.pesanan.add');
    Route::post('admin/pesanan/export', [AdminPesananController::class, 'export'])->name('admin.pesanan.export');
    Route::get('admin/pesanan/exportsemua', [AdminPesananController::class, 'export_semua'])->name('admin.pesanan.exportsemua');
    Route::get('admin/pesanan/getProduk/{id}', [AdminPesananController::class, 'get_produk'])->name('admin.pesanan.getProduk');
    Route::post('admin/pesanan/store', [AdminPesananController::class, 'store'])->name('admin.pesanan.store');
    Route::get('admin/pesanan/invoice/{kode_invoice}', [AdminPesananController::class, 'invoice'])->name('admin.pesanan.invoice');
    Route::get('admin/pesanan/selesai/invoice/{kode_invoice}', [AdminPesananController::class, 'invoice'])->name('admin.pesanan.selesai.invoice');
    Route::get('admin/pesanan/batal/invoice/{kode_invoice}', [AdminPesananController::class, 'invoice'])->name('admin.pesanan.batal.invoice');
    Route::get('admin/pesanan/konfirmasi/{kode_invoice}', [AdminPesananController::class, 'konfirmasi'])->name('admin.pesanan.konfirmasi');
    Route::get('admin/pesanan/kirim/{kode_invoice}', [AdminPesananController::class, 'kirim'])->name('admin.pesanan.kirim');
    Route::get('admin/pesanan/diselesaikan/{kode_invoice}', [AdminPesananController::class, 'diselesaikan'])->name('admin.pesanan.diselesaikan');
    Route::get('admin/pesanan/dibatalkan/{kode_invoice}', [AdminPesananController::class, 'dibatalkan'])->name('admin.pesanan.dibatalkan');
    Route::get('admin/pesanan/selesai', [AdminPesananController::class, 'selesai'])->name('admin.pesanan.selesai');
    Route::get('admin/pesanan/batal', [AdminPesananController::class, 'batal'])->name('admin.pesanan.batal');
    Route::get('admin/pesanan/getListData', [AdminPesananController::class, 'listData'])->name('admin.pesanan.list');
    Route::get('admin/pesanan/getListSelesai', [AdminPesananController::class, 'listSelesai'])->name('admin.pesanan.listselesai');
    Route::get('admin/pesanan/getListBatal', [AdminPesananController::class, 'listBatal'])->name('admin.pesanan.listbatal');

    Route::get('admin/kategoriproduk', [KategoriProdukController::class, 'index'])->name('admin.kategoriproduk');
    Route::get('admin/kategoriproduk/getListData', [KategoriProdukController::class, 'listData'])->name('admin.kategoriproduk.list');
    Route::get('admin/kategoriproduk/add', [KategoriProdukController::class, 'create'])->name('admin.kategoriproduk.add');
    Route::post('admin/kategoriproduk/store', [KategoriProdukController::class, 'store'])->name('admin.kategoriproduk.store');
    Route::get('admin/kategoriproduk/edit/{id}', [KategoriProdukController::class, 'edit'])->name('admin.kategoriproduk.edit');
    Route::put('admin/kategoriproduk/update/{id}', [KategoriProdukController::class, 'update'])->name('admin.kategoriproduk.update');
    Route::get('admin/kategoriproduk/delete/{id}', [KategoriProdukController::class, 'destroy'])->name('admin.kategoriproduk.delete');

    Route::get('admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
    Route::get('admin/pelanggan/getListData', [PelangganController::class, 'listData'])->name('admin.pelanggan.list');
    Route::get('admin/pelanggan/delete/{id}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.delete');

    Route::get('admin/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai');
    Route::get('admin/pegawai/getListData', [PegawaiController::class, 'listData'])->name('admin.pegawai.list');
    Route::get('admin/pegawai/add', [PegawaiController::class, 'create'])->name('admin.pegawai.add');
    Route::post('admin/pegawai/store', [PegawaiController::class, 'store'])->name('admin.pegawai.store');
    Route::get('admin/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('admin.pegawai.edit');
    Route::put('admin/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('admin.pegawai.update');
    Route::get('admin/pegawai/delete/{id}', [PegawaiController::class, 'destroy'])->name('admin.pegawai.delete');

    Route::get('admin/administrator', [AdministratorController::class, 'index'])->name('admin.administrator');
    Route::get('admin/administrator/getListData', [AdministratorController::class, 'listData'])->name('admin.administrator.list');
    Route::get('admin/administrator/add', [AdministratorController::class, 'create'])->name('admin.administrator.add');
    Route::post('admin/administrator/store', [AdministratorController::class, 'store'])->name('admin.administrator.store');
    Route::get('admin/administrator/edit/{id}', [AdministratorController::class, 'edit'])->name('admin.administrator.edit');
    Route::put('admin/administrator/update/{id}', [AdministratorController::class, 'update'])->name('admin.administrator.update');
    Route::get('admin/administrator/delete/{id}', [AdministratorController::class, 'destroy'])->name('admin.administrator.delete');

    Route::get('admin/produk', [ProdukController::class, 'index'])->name('admin.produk');
    Route::get('admin/produk/getListData', [ProdukController::class, 'listData'])->name('admin.produk.list');
    Route::get('admin/produk/add', [ProdukController::class, 'create'])->name('admin.produk.add');
    Route::post('admin/produk/store', [ProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('admin/produk/edit/{id}', [ProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('admin/produk/update/{id}', [ProdukController::class, 'update'])->name('admin.produk.update');
    Route::get('admin/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('admin.produk.delete');

    Route::get('admin/pembelian', [PembelianController::class, 'index'])->name('admin.pembelian');
    Route::get('admin/pembelian/getListData', [PembelianController::class, 'listData'])->name('admin.pembelian.list');
    Route::post('admin/pembelian/export', [PembelianController::class, 'export'])->name('admin.pembelian.export');
    Route::get('admin/pembelian/exportsemua', [PembelianController::class, 'export_semua'])->name('admin.pembelian.exportsemua');
    Route::get('admin/pembelian/add', [PembelianController::class, 'create'])->name('admin.pembelian.add');
    Route::get('admin/pembelian/getProduk/{id}', [PembelianController::class, 'get_produk'])->name('admin.pembelian.getProduk');
    Route::post('admin/pembelian/store', [PembelianController::class, 'store'])->name('admin.pembelian.store');
    Route::get('admin/pembelian/edit/{id}', [PembelianController::class, 'edit'])->name('admin.pembelian.edit');
    Route::put('admin/pembelian/update/{id}', [PembelianController::class, 'update'])->name('admin.pembelian.update');
    Route::get('admin/pembelian/delete/{id}', [PembelianController::class, 'destroy'])->name('admin.pembelian.delete');

    Route::get('admin/rekening', [RekeningController::class, 'index'])->name('admin.rekening');
    Route::get('admin/rekening/getListData', [RekeningController::class, 'listData'])->name('admin.rekening.list');
    Route::get('admin/rekening/add', [RekeningController::class, 'create'])->name('admin.rekening.add');
    Route::post('admin/rekening/store', [RekeningController::class, 'store'])->name('admin.rekening.store');
    Route::get('admin/rekening/edit/{id}', [RekeningController::class, 'edit'])->name('admin.rekening.edit');
    Route::put('admin/rekening/update/{id}', [RekeningController::class, 'update'])->name('admin.rekening.update');
    Route::get('admin/rekening/delete/{id}', [RekeningController::class, 'destroy'])->name('admin.rekening.delete');

    Route::get('admin/jasakirim', [JasaKirimController::class, 'index'])->name('admin.jasakirim');
    Route::get('admin/jasakirim/getListData', [JasaKirimController::class, 'listData'])->name('admin.jasakirim.list');
    Route::get('admin/jasakirim/add', [JasaKirimController::class, 'create'])->name('admin.jasakirim.add');
    Route::post('admin/jasakirim/store', [JasaKirimController::class, 'store'])->name('admin.jasakirim.store');
    Route::get('admin/jasakirim/edit/{id}', [JasaKirimController::class, 'edit'])->name('admin.jasakirim.edit');
    Route::put('admin/jasakirim/update/{id}', [JasaKirimController::class, 'update'])->name('admin.jasakirim.update');
    Route::get('admin/jasakirim/delete/{id}', [JasaKirimController::class, 'destroy'])->name('admin.jasakirim.delete');

    Route::get('admin/setting', [SettingController::class, 'index'])->name('admin.setting');
    Route::get('admin/setting/getListData', [SettingController::class, 'listData'])->name('admin.setting.list');
    Route::get('admin/setting/edit/{id}', [SettingController::class, 'edit'])->name('admin.setting.edit');
    Route::put('admin/setting/update/{id}', [SettingController::class, 'update'])->name('admin.setting.update');

});
