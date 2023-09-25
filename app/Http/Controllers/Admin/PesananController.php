<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PesananExport;
use App\Helpers\AllHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\JasaKirim;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    // Menampilkan halaman pesanan
    public function index()
    {
        $setting = Setting::first();

        return view('admin.pesanan.index', compact('setting'));
    }

    // Proses menampilkan data pesanan dengan datatables
    public function listData()
    {
        $data = Invoice::select('invoices.*')
            ->where('invoices.status', '<>', 0)
            ->where('invoices.status', '<>', 4)
            ->where('invoices.status', '<>', 5)
            ->orderBy('invoices.status', 'DESC');
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
                $ongkir = JasaKirim::where('id', $row->jasakirim_id);
                if ($ongkir->count() > 0) {
                    $pengiriman = $ongkir->first()->nama.' - '.AllHelper::rupiah($ongkir->first()->ongkir);
                } else {
                    $pengiriman = '<i class="text-primary">Beli langsung di toko</i>';
                }
                return $pengiriman;
            })
            ->addColumn('name', function($row) {
                $user = User::where('id', $row->user_id);
                if ($user->count() > 0) {
                    $name = '<span class="badge badge-primary">'.$user->first()->name.'</span>';
                } else {
                    $name = '<span class="badge badge-primary">Pembeli Toko</span>';
                }
                return $name;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('tanggal', function($row) {
                $tgl = date('d M Y', strtotime($row->created_at));
                return $tgl;
            })
            ->addColumn('status', function($row) {
                if ($row->status == 1 && $row->konfirmasi == 0) {
                    $status = '<span class="badge badge-danger">Belum dibayar</span>';
                } elseif ($row->status == 1 && $row->konfirmasi == 1) {
                    $status = '<span class="badge badge-warning">Menunggu konfirmasi</span>';
                } elseif ($row->status == 2) {
                    $status = '<span class="badge badge-primary">Pesanan sedang diproses</span>';
                } elseif ($row->status == 3) {
                    $status = '<span class="badge badge-info">Pesanan sedang dikirim</span>';
                }

                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pesanan.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mb-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a><br>';
                if ($row->status == 1 && $row->konfirmasi == 0) {
                    $btn .= '<a href="'.route('admin.pesanan.dibatalkan', $row->kode_invoice).'" class="btn btn-danger btn-sm" title="Batalkan">
                            <i class="fas"> X </i>
                        </a>';
                } elseif ($row->status == 1 && $row->konfirmasi == 1) {
                    $btn .= '<a href="'.route('admin.pesanan.konfirmasi', $row->kode_invoice).'" class="btn btn-info btn-sm mb-2" title="Konfirmasi">
                            <i class="fas fa-check"></i>
                        </a><br>';
                    $btn .= '<a href="'.route('admin.pesanan.dibatalkan', $row->kode_invoice).'" class="btn btn-danger btn-sm" title="Batalkan">
                            <i class="fas"> X </i>
                        </a>';
                } elseif ($row->status == 2) {
                    $btn .= '<a href="'.route('admin.pesanan.kirim', $row->kode_invoice).'" class="btn btn-warning btn-sm" title="Kirim">
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>';
                } elseif ($row->status == 3) {
                    $btn .= '<a href="'.route('admin.pesanan.diselesaikan', $row->kode_invoice).'" class="btn btn-success btn-sm" title="Selesai">
                            <i class="fas fa-check"></i>
                        </a>';
                }

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir', 'name', 'tanggal'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman pesanan selesai
    public function selesai()
    {
        $setting = Setting::first();

        return view('admin.pesanan.selesai', compact('setting'));
    }

    // Proses menampilkan data pesanan dengan datatables
    public function listSelesai()
    {
        $data = Invoice::select('invoices.*')
            ->where('invoices.status', 4)
            ->orderBy('invoices.status', 'DESC');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('bukti', function($row) {
                $pembayaran = Pembayaran::where('invoice_id', $row->id);
                if ($pembayaran->count() > 0) {
                    $bukti = '<a href="'.url($pembayaran->first()->bukti).'" target="_blank"><img src="'.url($pembayaran->first()->bukti).'" width="70"></a>';
                } else {
                    if($row->konfirmasi == 1) {
                        $bukti = '<i class="text-primary">Beli langsung di toko</i>';
                    } else {
                        $bukti = '<i class="text-danger">Belum ada bukti pembayaran</i>';
                    }
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
                $ongkir = JasaKirim::where('id', $row->jasakirim_id);
                if ($ongkir->count() > 0) {
                    $pengiriman = $ongkir->first()->nama.' - '.AllHelper::rupiah($ongkir->first()->ongkir);
                } else {
                    $pengiriman = '<i class="text-primary">Beli langsung di toko</i>';
                }
                return $pengiriman;
            })
            ->addColumn('name', function($row) {
                $user = User::where('id', $row->user_id);
                if ($user->count() > 0) {
                    $name = '<span class="badge badge-primary">'.$user->first()->name.'</span>';
                } else {
                    $name = '<span class="badge badge-primary">Pembeli Toko</span>';
                }
                return $name;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge badge-success">Pesanan telah selesai</span>';

                return $status;
            })
            ->addColumn('tanggal', function($row) {
                $tgl = date('d M Y', strtotime($row->created_at));
                return $tgl;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pesanan.selesai.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mr-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a>';
                if ($row->status == 1 && $row->konfirmasi == 1) {
                    $btn .= '<a href="'.route('admin.pesanan.konfirmasi', $row->kode_invoice).'" class="btn btn-info btn-sm" title="Konfirmasi">
                            <i class="fas fa-check"></i>
                        </a>';
                } elseif ($row->status == 2) {
                    $btn .= '<a href="'.route('admin.pesanan.kirim', $row->kode_invoice).'" class="btn btn-warning btn-sm" title="Kirim">
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>';
                } elseif ($row->status == 3) {
                    $btn .= '<a href="'.route('admin.pesanan.diselesaikan', $row->kode_invoice).'" class="btn btn-success btn-sm" title="Selesai">
                            <i class="fas fa-check"></i>
                        </a>';
                }

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir', 'name', 'tanggal'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman tambah pesanan
    public function create()
    {
        $setting = Setting::first();
        $kode_invoice = 'INVPSBNS'.date('dmY').strtoupper(Str::random(5));
        $produk = Produk::orderBy('id', 'DESC')->get();

        return view('admin.pesanan.add', compact('setting', 'kode_invoice', 'produk'));
    }

    // Proses tambah pesanan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_invoice' => 'required',
            'produk' => 'required',
            'harga_produk' => 'required',
            'jumlah' => 'required',
            'total' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $invoice = new Invoice;
        $invoice->kode_invoice = $request->get('kode_invoice');
        $invoice->total_invoice = $request->get('total');
        $invoice->status = 4;
        $invoice->konfirmasi = 1;
        $invoice->save();

        Transaksi::create([
            'invoice_id' => $invoice->id,
            'produk_id' => $request->get('produk'),
            'jumlah' => $request->get('jumlah'),
            'total' => $request->get('total')
        ]);

        $produk = Produk::find($request->get('produk'));
        $produk->stok = $produk->stok - $request->get('jumlah');
        $produk->save();

        return redirect()->route('admin.pesanan')->with('berhasil', 'Berhasil menambahkan pesanan baru.');
    }

    public function get_produk($id)
    {
        $produk = Produk::find($id);

        return json_encode($produk);
    }

    // Menampilkan halaman pesanan selesai
    public function batal()
    {
        $setting = Setting::first();

        return view('admin.pesanan.batal', compact('setting'));
    }

    // Proses menampilkan data pesanan dengan datatables
    public function listBatal()
    {
        $data = Invoice::select('invoices.*')
            ->where('invoices.status', 5)
            ->orderBy('invoices.status', 'DESC');
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
                $ongkir = JasaKirim::where('id', $row->jasakirim_id);
                if ($ongkir->count() > 0) {
                    $pengiriman = $ongkir->first()->nama.' - '.AllHelper::rupiah($ongkir->first()->ongkir);
                } else {
                    $pengiriman = '<i class="text-primary">Beli langsung di toko</i>';
                }
                return $pengiriman;
            })
            ->addColumn('name', function($row) {
                $user = User::where('id', $row->user_id);
                if ($user->count() > 0) {
                    $name = '<span class="badge badge-primary">'.$user->first()->name.'</span>';
                } else {
                    $name = '<span class="badge badge-primary">Pembeli Toko</span>';
                }
                return $name;
            })
            ->addColumn('total_invoice', function($row) {
                $hrg = AllHelper::rupiah($row->total_invoice);
                return $hrg;
            })
            ->addColumn('status', function($row) {
                $status = '<span class="badge badge-danger">Pesanan telah dibatalkan</span>';

                return $status;
            })
            ->addColumn('tanggal', function($row) {
                $tgl = date('d M Y', strtotime($row->created_at));
                return $tgl;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pesanan.batal.invoice', $row->kode_invoice).'" class="btn btn-primary btn-sm mr-2" title="Lihat Invoice">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'status', 'total_invoice', 'bukti', 'produk', 'harga_produk', 'jumlah', 'subtotal', 'ongkir', 'name', 'tanggal'])
            ->make(true);
        
        return $datatables;
    }

    // Proses export excel pesanan
    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'dari' => 'required',
            'sampai' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        return (new PesananExport($request->status, $request->dari, $request->sampai))
            ->download('Laporan-Pesanan-'.date('dmY', strtotime($request->dari)).'-'.date('dmY', strtotime($request->sampai)).'-'.Str::random(5).'.xlsx');
    }

    // Proses export semua excel pesanan
    public function export_semua(Request $request)
    {        
        return (new PesananExport($request->status, $request->dari, $request->sampai))
            ->download('Laporan-Pesanan-Semua-'.Str::random(5).'.xlsx');
    }

    // Proses konfirmasi pesanan
    public function konfirmasi($kode_invoice)
    {
        $invoice = Invoice::where('kode_invoice', $kode_invoice)->first();
        $invoice->status = 2;
        $invoice->save();

        return redirect()->route('admin.pesanan')->with('berhasil', 'Pesanan sedang diproses.');
    }

    // Proses kirim pesanan
    public function kirim($kode_invoice)
    {
        $invoice = Invoice::where('kode_invoice', $kode_invoice)->first();
        $invoice->status = 3;
        $invoice->save();

        return redirect()->route('admin.pesanan')->with('berhasil', 'Pesanan sedang dikirim.');
    }

    // Proses selesai pesanan
    public function diselesaikan($kode_invoice)
    {
        $invoice = Invoice::where('kode_invoice', $kode_invoice)->first();
        $invoice->status = 4;
        $invoice->save();

        $transaksi = Transaksi::where('invoice_id', $invoice->id)->get();
        foreach ($transaksi as $row) { 
            $produk = Produk::find($row->produk_id);
            $produk->stok = $produk->stok - $row->jumlah;
            $produk->save();
        }

        return redirect()->route('admin.pesanan')->with('berhasil', 'Pesanan telah selesai.');
    }

    // Proses batalkan pesanan
    public function dibatalkan($kode_invoice)
    {
        $invoice = Invoice::where('kode_invoice', $kode_invoice)->first();
        $invoice->status = 5;
        $invoice->save();

        return redirect()->route('admin.pesanan')->with('berhasil', 'Pesanan telah dibatalkan.');
    }

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

        return view('admin.pesanan.invoice', compact('setting', 'invoice', 'transaksi', 'transaksi_detail'));
    }
}
