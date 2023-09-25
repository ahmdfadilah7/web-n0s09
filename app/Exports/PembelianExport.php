<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Pembelian;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PembelianExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public $dari;
    public $sampai;

    public function __construct($dari, $sampai) 
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $setting = Setting::first();
        if ($this->dari <> '' && $this->sampai <> '') {
            $pembelian = Pembelian::select('pembelians.*', 'produks.nama', 'produks.harga_modal')
                ->join('produks', 'pembelians.produk_id', 'produks.id')
                ->whereDate('pembelians.created_at', '>=', $this->dari)
                ->whereDate('pembelians.created_at', '<=', $this->sampai)
                ->orderBy('pembelians.id', 'DESC')
                ->get();        
        } else {
            $pembelian = Pembelian::select('pembelians.*', 'produks.nama', 'produks.harga_modal')
                ->join('produks', 'pembelians.produk_id', 'produks.id')
                ->orderBy('pembelians.id', 'DESC')
                ->get();
        }

        return view('admin.pembelian.excel', compact('setting', 'pembelian'));
    }
}
