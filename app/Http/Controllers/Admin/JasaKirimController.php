<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AllHelper;
use App\Http\Controllers\Controller;
use App\Models\JasaKirim;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JasaKirimController extends Controller
{
    // Menampilkan halaman jasa kirim
    public function index()
    {
        $setting = Setting::first();

        return view('admin.jasakirim.index', compact('setting'));
    }

    // Proses menampilkan data jasakirim dengan datatables
    public function listData()
    {
        $data = JasaKirim::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('ongkir', function($row) {
                $hrg = AllHelper::rupiah($row->ongkir);
                return $hrg;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.jasakirim.edit', $row->id).'" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                $btn .= '<a href="'.route('admin.jasakirim.delete', $row->id).'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'ongkir'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman tambah jasakirim
    public function create()
    {
        $setting = Setting::first();

        return view('admin.jasakirim.add', compact('setting'));
    }

    // Proses menambahkan jasakirim
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'ongkir' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        jasakirim::create([
            'nama' => $request->get('nama'),
            'ongkir' => str_replace(',', '', $request->get('ongkir'))
        ]);

        return redirect()->route('admin.jasakirim')->with('berhasil', 'Berhasil menambahkan jasa kirim baru.');
    }

    // Menampilkan halaman edit jasakirim
    public function edit($id)
    {
        $setting = Setting::first();
        $jasakirim = JasaKirim::find($id);

        return view('admin.jasakirim.edit', compact('setting', 'jasakirim'));
    }

    // Proses mengupdate jasakirim
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'ongkir' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $jasakirim = JasaKirim::find($id);
        $jasakirim->nama = $request->get('nama');
        $jasakirim->ongkir = str_replace(',', '', $request->get('ongkir'));
        $jasakirim->save();

        return redirect()->route('admin.jasakirim')->with('berhasil', 'Berhasil mengupdate jasa kirim.');
    }

    // Proses menghapus jasakirim
    public function destroy($id)
    {
        $jasakirim = JasaKirim::find($id);
        $jasakirim->delete();

        return redirect()->route('admin.jasakirim')->with('berhasil', 'Berhasil menghapus jasa kirim.');
    }
}
