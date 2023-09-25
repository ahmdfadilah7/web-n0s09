<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    // Menampilkan halaman pelanggan
    public function index()
    {
        $setting = Setting::first();

        return view('admin.pelanggan.index', compact('setting'));
    }

    // Proses menampilkan data pelanggan dengan datatables
    public function listData()
    {
        $data = User::select('users.*', 'profiles.foto', 'profiles.no_telp')
            ->join('profiles', 'profiles.user_id', 'users.id')
            ->where('role', 'Pelanggan');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('foto', function($row) {
                if ($row->foto <> '') {
                    $img = '<img src="'.url($row->foto).'" width="70">';
                } else {
                    $img = '<i class="text-danger">Belum ada foto</i>';
                }
                return $img;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pelanggan.delete', $row->id).'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'foto'])
            ->make(true);
        
        return $datatables;
    }

    // Proses menghapus pelanggan
    public function destroy($id)
    {
        $user = User::select('users.*', 'profiles.foto', 'profiles.no_telp')
            ->join('profiles', 'profiles.user_id', 'users.id')
            ->where('role', 'Pelanggan')
            ->find($id);
        $user->delete();

        File::delete($user->foto);

        return redirect()->route('admin.pelanggan')->with('berhasil', 'Berhasil menghapus pelanggan.');
    }
}
