<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PembelianExport;
use App\Helpers\AllHelper;
use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    // Menampilkan halaman pembelian
    public function index()
    {
        $setting = Setting::first();

        return view('admin.pembelian.index', compact('setting'));
    }

    // Proses menampilkan data pembelian dengan datatable
    public function listData()
    {
        $data = Pembelian::select('pembelians.*', 'produks.nama')
            ->join('produks', 'pembelians.produk_id', 'produks.id');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('total', function($row) {
                $hrg = AllHelper::rupiah($row->total);
                return $hrg;
            })
            ->addColumn('tanggal', function($row) {
                $tgl = date('d M Y', strtotime($row->created_at));
                return $tgl;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pembelian.delete', $row->id).'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'total', 'tanggal'])
            ->make(true);
        
        return $datatables;
    }

    // Proses export excel pembelian
    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        return (new PembelianExport($request->dari, $request->sampai))
            ->download('Laporan-Pembelian-'.date('dmY', strtotime($request->dari)).'-'.date('dmY', strtotime($request->sampai)).'-'.Str::random(5).'.xlsx');
    }

    // Proses export semua excel pembelian
    public function export_semua(Request $request)
    {        
        return (new PembelianExport($request->dari, $request->sampai))
            ->download('Laporan-Pembelian-Semua-'.Str::random(5).'.xlsx');
    }

    // Menampilkan halaman tambah pembelian
    public function create()
    {
        $setting = Setting::first();
        $produk = Produk::orderBy('id', 'DESC')->get();

        return view('admin.pembelian.add', compact('setting', 'produk'));
    }

    public function get_produk($id)
    {
        $produk = Produk::find($id);

        return json_encode($produk);
    }

    // Proses menambahkan pembelian
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required',
            'produk' => 'required',
            'harga_modal' => 'required',
            'jumlah' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Pembelian::create([
            'nama_supplier' => $request->get('nama_supplier'),
            'produk_id' => $request->get('produk'),
            'jumlah' => $request->get('jumlah'),
            'total' => $request->get('harga_modal') * $request->get('jumlah'),
        ]);

        $produk = Produk::find($request->get('produk'));
        $produk->stok = $produk->stok + $request->get('jumlah');
        $produk->save();

        return redirect()->route('admin.pembelian')->with('berhasil', 'Berhasil menambahkan pembelian baru.');
    }

    // Proses menghapus pembelian
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->delete();

        $produk = Produk::find($pembelian->produk_id);
        $produk->stok = $produk->stok - $pembelian->jumlah;
        $produk->save();

        return redirect()->route('admin.pembelian')->with('berhasil', 'Berhasil menghapus pembelian.');
    }
}
