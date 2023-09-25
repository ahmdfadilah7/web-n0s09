<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Invoice;
use App\Models\Pembayaran;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    // Menampilkan halaman pesanan
    public function index()
    {
        $setting = Setting::first();
        $invoice = Invoice::where('status', 0)->where('user_id', Auth::guard('pelanggan')->user()->id)->first();
        if ($invoice <> '') {
            $transaksi = Transaksi::where('invoice_id', $invoice->id)->count();
        } else {
            $transaksi = 0;
        }
        $belumbayar = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 1)
            ->where('konfirmasi', 0)->count();
        $menunggukonfirmasi = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 1)
            ->where('konfirmasi', 1)->count();
        $diproses = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 2)
            ->count();
        $dikirim = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 3)
            ->count();
        $selesai = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 4)
            ->count();
        $batal = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 5)
            ->count();

        return view('pesanan.index', compact('setting', 'invoice', 'transaksi', 'belumbayar', 'menunggukonfirmasi', 'diproses', 'dikirim', 'selesai', 'batal'));
    }

    // Proses menampilkan data transaksi dengan datatable
    public function listBelumBayar()
    {
        $data = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 1)
            ->where('konfirmasi', 0);
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('bukti', function($row) {
                $pembayaran = Pembayaran::where('invoice_id', $row->id);
                if ($pembayaran->count() > 0) {
                    $bukti = '<a href="'.url($pembayaran->first()->bukti).'" target="_blank"><img src="'.url($pembayaran->first()->bukti).'" width="70"></a>';
                } else {
                    $bukti = '<i class="text-danger">Belum ada bukti pembayaran</i>';
                }
                return $bukti;
            })
            ->addColumn('produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->nama.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('harga_produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->harga_jual).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('jumlah', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->jumlah.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('subtotal', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->total).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('ongkir', function($row) {
                $hrg = $row->nama.' - '.AllHelper::rupiah($row->ongkir);
                return $hrg;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge bg-danger">Pesanan belum dibayar</span>';

                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pesanan.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mb-2" title="Lihat Invoice" style="margin-right: 10px">
                        <i class="fas fa-eye"></i>
                    </a>';
                $btn .= '<a href="'.route('keranjang.invoice', $row->kode_invoice).'" class="btn btn-success btn-sm mr-2" title="Bayar">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir'])
            ->make(true);
        
        return $datatables;
    }

    // Proses menampilkan data transaksi dengan datatable
    public function listMenungguKonfirmasi()
    {
        $data = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 1)
            ->where('konfirmasi', 1);
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('bukti', function($row) {
                $pembayaran = Pembayaran::where('invoice_id', $row->id);
                if ($pembayaran->count() > 0) {
                    $bukti = '<a href="'.url($pembayaran->first()->bukti).'" target="_blank"><img src="'.url($pembayaran->first()->bukti).'" width="70"></a>';
                } else {
                    $bukti = '<i class="text-danger">Belum ada bukti pembayaran</i>';
                }
                return $bukti;
            })
            ->addColumn('produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->nama.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('harga_produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->harga_jual).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('jumlah', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->jumlah.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('subtotal', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->total).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('ongkir', function($row) {
                $hrg = $row->nama.' - '.AllHelper::rupiah($row->ongkir);
                return $hrg;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge bg-primary">Menunggu Konfirmasi</span>';

                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pesanan.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mr-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir'])
            ->make(true);
        
        return $datatables;
    }

    // Proses menampilkan data transaksi dengan datatable
    public function listDiproses()
    {
        $data = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 2)
            ->where('konfirmasi', 1);
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('bukti', function($row) {
                $pembayaran = Pembayaran::where('invoice_id', $row->id);
                if ($pembayaran->count() > 0) {
                    $bukti = '<a href="'.url($pembayaran->first()->bukti).'" target="_blank"><img src="'.url($pembayaran->first()->bukti).'" width="70"></a>';
                } else {
                    $bukti = '<i class="text-danger">Belum ada bukti pembayaran</i>';
                }
                return $bukti;
            })
            ->addColumn('produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->nama.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('harga_produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->harga_jual).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('jumlah', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->jumlah.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('subtotal', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->total).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('ongkir', function($row) {
                $hrg = $row->nama.' - '.AllHelper::rupiah($row->ongkir);
                return $hrg;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge bg-primary">Pesanan sedang diproses</span>';

                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pesanan.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mr-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir'])
            ->make(true);
        
        return $datatables;
    }

    // Proses menampilkan data transaksi dengan datatable
    public function listDikirim()
    {
        $data = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 3)
            ->where('konfirmasi', 1);
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('bukti', function($row) {
                $pembayaran = Pembayaran::where('invoice_id', $row->id);
                if ($pembayaran->count() > 0) {
                    $bukti = '<a href="'.url($pembayaran->first()->bukti).'" target="_blank"><img src="'.url($pembayaran->first()->bukti).'" width="70"></a>';
                } else {
                    $bukti = '<i class="text-danger">Belum ada bukti pembayaran</i>';
                }
                return $bukti;
            })
            ->addColumn('produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->nama.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('harga_produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->harga_jual).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('jumlah', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->jumlah.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('subtotal', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->total).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('ongkir', function($row) {
                $hrg = $row->nama.' - '.AllHelper::rupiah($row->ongkir);
                return $hrg;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge bg-warning">Pesanan sedang dikirim</span>';

                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pesanan.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mr-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir'])
            ->make(true);
        
        return $datatables;
    }

    // Proses menampilkan data transaksi dengan datatable
    public function listSelesai()
    {
        $data = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 4)
            ->where('konfirmasi', 1);
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('bukti', function($row) {
                $pembayaran = Pembayaran::where('invoice_id', $row->id);
                if ($pembayaran->count() > 0) {
                    $bukti = '<a href="'.url($pembayaran->first()->bukti).'" target="_blank"><img src="'.url($pembayaran->first()->bukti).'" width="70"></a>';
                } else {
                    $bukti = '<i class="text-danger">Belum ada bukti pembayaran</i>';
                }
                return $bukti;
            })
            ->addColumn('produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->nama.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('harga_produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->harga_jual).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('jumlah', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->jumlah.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('subtotal', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->total).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('ongkir', function($row) {
                $hrg = $row->nama.' - '.AllHelper::rupiah($row->ongkir);
                return $hrg;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge bg-success">Pesanan telah selesai</span>';

                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pesanan.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mr-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir'])
            ->make(true);
        
        return $datatables;
    }

    // Proses menampilkan data transaksi dengan datatable
    public function listBatal()
    {
        $data = Invoice::select('invoices.*', 'jasa_kirims.ongkir', 'jasa_kirims.nama')
            ->join('jasa_kirims', 'invoices.jasakirim_id', 'jasa_kirims.id')
            ->where('user_id', Auth::guard('pelanggan')->user()->id)
            ->where('status', 5);
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('bukti', function($row) {
                $pembayaran = Pembayaran::where('invoice_id', $row->id);
                if ($pembayaran->count() > 0) {
                    $bukti = '<a href="'.url($pembayaran->first()->bukti).'" target="_blank"><img src="'.url($pembayaran->first()->bukti).'" width="70"></a>';
                } else {
                    $bukti = '<i class="text-danger">Belum ada bukti pembayaran</i>';
                }
                return $bukti;
            })
            ->addColumn('produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->nama.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('harga_produk', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->harga_jual).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('jumlah', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= $row->jumlah.'<br>';
                }
                
                return $produk;
            })
            ->addColumn('subtotal', function($row) {
                $transaksi = Transaksi::select('transaksis.*', 'produks.nama', 'produks.harga_jual')
                    ->join('produks', 'transaksis.produk_id', 'produks.id')
                    ->where('invoice_id', $row->id)
                    ->get();
                $produk = '';
                foreach ($transaksi as $row) {
                    $produk .= AllHelper::rupiah($row->total).'<br>';
                }
                
                return $produk;
            })
            ->addColumn('ongkir', function($row) {
                $hrg = $row->nama.' - '.AllHelper::rupiah($row->ongkir);
                return $hrg;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge bg-danger">Pesanan telah dibatalkan</span>';

                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pesanan.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mr-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir'])
            ->make(true);
        
        return $datatables;
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

        return view('pesanan.invoice', compact('setting', 'invoice', 'transaksi', 'transaksi_detail'));
    }
}
