<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RekeningController extends Controller
{
    // Menampilkan halaman rekening
    public function index()
    {
        $setting = Setting::first();

        return view('admin.rekening.index', compact('setting'));
    }

    // Proses menampilkan data rekening dengan datatables
    public function listData()
    {
        $data = Rekening::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.rekening.edit', $row->id).'" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                $btn .= '<a href="'.route('admin.rekening.delete', $row->id).'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        
        return $datatables;
    }

    // Menampilkan halaman tambah rekening
    public function create()
    {
        $setting = Setting::first();

        return view('admin.rekening.add', compact('setting'));
    }

    // Proses menambahkan rekening
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_rekening' => 'required',
            'no_rekening' => 'required',
            'bank' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Rekening::create([
            'nama_rekening' => $request->get('nama_rekening'),
            'no_rekening' => $request->get('no_rekening'),
            'bank' => $request->get('bank')
        ]);

        return redirect()->route('admin.rekening')->with('berhasil', 'Berhasil menambahkan rekening baru.');
    }

    // Menampilkan halaman edit rekening
    public function edit($id)
    {
        $setting = Setting::first();
        $rekening = Rekening::find($id);

        return view('admin.rekening.edit', compact('setting', 'rekening'));
    }

    // Proses mengupdate rekening
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_rekening' => 'required',
            'no_rekening' => 'required',
            'bank' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $rekening = Rekening::find($id);
        $rekening->nama_rekening = $request->get('nama_rekening');
        $rekening->no_rekening = $request->get('no_rekening');
        $rekening->bank = $request->get('bank');
        $rekening->save();

        return redirect()->route('admin.rekening')->with('berhasil', 'Berhasil mengupdate rekening.');
    }

    // Proses menghapus rekening
    public function destroy($id)
    {
        $rekening = Rekening::find($id);
        $rekening->delete();

        return redirect()->route('admin.rekening')->with('berhasil', 'Berhasil menghapus rekening.');
    }
}
