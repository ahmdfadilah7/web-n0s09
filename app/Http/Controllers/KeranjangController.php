<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Invoice;
use App\Models\JasaKirim;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Rekening;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KeranjangController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $setting = Setting::first();
        $invoice = Invoice::where('status', 0)->where('user_id', Auth::guard('pelanggan')->user()->id)->first();
        if ($invoice <> '') {
            $transaksi = Transaksi::where('invoice_id', $invoice->id)->count();
            $transaksi_detail = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual', 'produks.gambar', 'produks.slug')
                ->join('produks', 'transaksis.produk_id', 'produks.id')
                ->where('invoice_id', $invoice->id)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $transaksi = 0;
            $transaksi_detail = '';
        }

        return view('keranjang.index', compact('setting', 'invoice', 'transaksi', 'transaksi_detail'));
    }

    // Menampilkan halaman checkout
    public function checkout($kode_invoice)
    {
        $setting = Setting::first();
        $invoice = Invoice::where('status', 0)->where('kode_invoice', $kode_invoice)->first();
        if ($invoice <> '') {
            $transaksi = Transaksi::where('invoice_id', $invoice->id)->count();
            $transaksi_detail = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual', 'produks.gambar', 'produks.slug')
                ->join('produks', 'transaksis.produk_id', 'produks.id')
                ->where('invoice_id', $invoice->id)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $transaksi = 0;
            $transaksi_detail = '';
        }
        $rekening = Rekening::orderBy('id', 'DESC')->get();
        $pengiriman = JasaKirim::orderBy('id', 'DESC')->get();

        return view('keranjang.checkout', compact('setting', 'invoice', 'transaksi', 'transaksi_detail', 'rekening', 'pengiriman'));
    }

    // Menampilkan halaman invoice
    public function invoice($kode_invoice)
    {
        $setting = Setting::first();
        $invoice = Invoice::select(
                'invoices.*', 
                'users.name', 
                'users.email', 
                'profiles.alamat', 
                'profiles.no_telp', 
                'jasa_kirims.nama', 
                'jasa_kirims.ongkir', 
                'rekenings.nama_rekening', 
                'rekenings.no_rekening', 
                'rekenings.bank'
            )
            ->join('users', 'invoices.user_id', 'users.id')
            ->join('profiles', 'profiles.user_id', 'users.id')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->join('rekenings', 'invoices.rekening_id', 'rekenings.id')
            ->where('kode_invoice', $kode_invoice)
            ->first();
        if ($invoice <> '') {
            $transaksi = Transaksi::where('invoice_id', $invoice->id)->count();
            $transaksi_detail = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual', 'produks.gambar', 'produks.slug')
                ->join('produks', 'transaksis.produk_id', 'produks.id')
                ->where('invoice_id', $invoice->id)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $transaksi = 0;
            $transaksi_detail = '';
        }

        return view('keranjang.invoice', compact('setting', 'invoice', 'transaksi', 'transaksi_detail'));
    }

    // Menampilkan halaman proses invoice
    public function proses_invoice(Request $request, $kode_invoice)
    {
        $validator = Validator::make($request->all(), [
            'rekening' => 'required',
            'pengiriman' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        if ($request->pengiriman == 0) {
            $errors = 'pengiriman wajib diisi !!';
            return back()->with('warning', $errors);
        }

        $invoice = Invoice::where('kode_invoice', $kode_invoice)->first();
        $invoice->jasakirim_id = $request->get('pengiriman');
        $invoice->rekening_id = $request->get('rekening');
        $invoice->total_invoice = $request->get('total_invoice');
        $invoice->status = 1;
        $invoice->save();

        return redirect()->route('keranjang.invoice', $kode_invoice);
    }

    // Menampilkan halaman bayar
    public function bayar($kode_invoice)
    {
        $invoice = Invoice::where('kode_invoice', $kode_invoice)->first();
        
        $data = array(
            'kode_invoice' => $kode_invoice,
            'total' => AllHelper::rupiah($invoice->total_invoice)
        );

        return json_encode($data);
    }

    // Proses pembayaran
    public function proses_pembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bukti_pembayaran' => 'required|mimes:png,jpg,jpeg,svg,webp'
        ],
        [
            'required' => ':attribute wajib diisi !!',
            'mimes' => ':attribute harus sesuai dengan format :mimes'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $invoice = Invoice::where('kode_invoice', $request->kode_invoice)->first();
        $invoice->konfirmasi = 1;
        $invoice->save();

        $gambar = $request->file('bukti_pembayaran');
        $namagambar = 'Bukti-Pembayaran-'.str_replace(' ', '-', $request->get('kode_invoice')).Str::random(5).'.'.$gambar->extension();
        $gambar->move(public_path('images/'), $namagambar);
        $gambarNama = 'images/'.$namagambar;

        Pembayaran::create([
            'invoice_id' => $invoice->id,
            'bukti' => $gambarNama,
            'status' => 0
        ]);

        return redirect()->route('keranjang')->with('berhasil', 'Berhasil melakukan pembayaran.');
    }

    // Menampilkan halaman pengiriman
    public function pengiriman($id, $kode_invoice)
    {
        $ongkir = JasaKirim::where('id', $id)->first();
        $cek_data = JasaKirim::where('id', $id)->count();
        $invoice = Invoice::where('kode_invoice', $kode_invoice)->first();
        $transaksi = Transaksi::where('invoice_id', $invoice->id)->get();
        foreach ($transaksi as $row) {
            $total[] = $row->total;
        }

        if ($cek_data > 0) {
            $ongkos = $ongkir->ongkir;
            $total = $ongkir->ongkir + array_sum($total);
        } else {
            $ongkos = 0;
            $total = array_sum($total);
        }

        $data = array(
            'ongkir' => AllHelper::rupiah($ongkos),
            'total' => AllHelper::rupiah($total),
            'totalclear' => $total,
        );

        return json_encode($data);
    }

    // Proses menambahkan produk ke keranjang
    public function store(Request $request)
    {
        $invoiceID = Invoice::where('user_id', Auth::guard('pelanggan')->user()->id)->where('status', 0);

        if ($invoiceID->count() > 0) {
            $transaksi = Transaksi::where('invoice_id', $invoiceID->first()->id)
                    ->where('produk_id', $request->get('produk_id'));
            if ($transaksi->count() > 0) {
                if ($request->get('jumlah') > 0) {
                    $produk = Produk::find($request->produk_id);
                    if ($request->get('jumlah') > $produk->stok) {
                        return back()->with('warning', 'Stok produk tidak cukup.');
                    } else {
                        $transaksiupdate = Transaksi::find($transaksi->first()->id);
                        $transaksiupdate->jumlah = $transaksi->first()->jumlah + $request->get('jumlah');
                        $transaksiupdate->total = $request->get('harga_produk') * $transaksiupdate->jumlah;
                        $transaksiupdate->save();
                    }
                } else {
                    return back()->with('warning', 'Jumlah tidak boleh kosong.');
                }
            } else {
                if ($request->get('jumlah') > 0) {
                    $produk = Produk::find($request->produk_id);
                    if ($request->get('jumlah') > $produk->stok) {
                        return back()->with('warning', 'Stok produk tidak cukup.');
                    } else {
                        Transaksi::create([
                            'invoice_id' => $invoiceID->first()->id,
                            'produk_id' => $request->get('produk_id'),
                            'jumlah' => $request->get('jumlah'),
                            'total' => $request->get('harga_produk')*$request->get('jumlah')
                        ]);
                    }
                } else {
                    return back()->with('warning', 'Jumlah tidak boleh kosong.');
                }
            }

            return back()->with('berhasil', 'Berhasil menambahkan produk ke keranjang.');
        } else {
            if ($request->get('jumlah') > 0) {
                $produk = Produk::find($request->produk_id);
                if ($request->get('jumlah') > $produk->stok) {
                    return back()->with('warning', 'Stok produk tidak cukup.');
                } else {       
                    $kode_invoice = 'INVPSBNS'.date('dmY').strtoupper(Str::random(5));
                    $invoice = new Invoice;
                    $invoice->kode_invoice = $kode_invoice;
                    $invoice->user_id = Auth::guard('pelanggan')->user()->id;
                    $invoice->status = 0;
                    $invoice->konfirmasi = 0;
                    $invoice->save();
        
                    Transaksi::create([
                        'invoice_id' => $invoice->id,
                        'produk_id' => $request->get('produk_id'),
                        'jumlah' => $request->get('jumlah'),
                        'total' => $request->get('harga_produk')*$request->get('jumlah')
                    ]);
                }         
            } else {
                return back()->with('warning', 'Jumlah tidak boleh kosong.');
            }

            return back()->with('berhasil', 'Berhasil menambahkan produk ke keranjang.');
        }
    }

    // Proses update jumlah
    public function update_jumlah(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $transaksi = Transaksi::find($id);
        if ($request->get('jumlah') > 0) {
            $produk = Produk::find($transaksi->produk_id);
            if ($request->get('jumlah') > $produk->stok) {
                return redirect()->route('keranjang')->with('warning', 'Stok produk tidak cukup.');
            } else {
                if ($transaksi->jumlah > $request->get('jumlah')) {
                    $hasil = 'berkurang';
                } else {
                    $hasil = 'bertambah';
                }
                $transaksi->jumlah = $request->get('jumlah');
                $transaksi->total = $transaksi->jumlah * $request->get('harga_produk');
                $transaksi->save();
             
                if ($hasil == 'bertambah') {
                    return redirect()->route('keranjang')->with('berhasil', 'Berhasil menambahkan jumlah.');
                } else {
                    return redirect()->route('keranjang')->with('berhasil', 'Berhasil mengurangi jumlah.');
                }
            }
        } else {
            return redirect()->route('keranjang')->with('warning', 'Jumlah tidak boleh kosong.');
        }
    }

    // Proses menghapus produk dari keranjang
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();

        return redirect()->route('keranjang')->with('berhasil', 'Berhasil menghapus produk dari keranjang.');
    }
}
