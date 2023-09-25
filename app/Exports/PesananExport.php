<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesananExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public $status;
    public $dari;
    public $sampai;

    public function __construct($status, $dari, $sampai) 
    {
        $this->status = $status;
        $this->dari = $dari;
        $this->sampai = $sampai;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $setting = Setting::first();
        if ($this->status == 'semua' && $this->dari <> '' && $this->sampai <> '') {
            $invoice = Invoice::select('invoices.*')
                ->where('invoices.status', '<>', 0)
                ->whereDate('created_at', '>=', $this->dari)
                ->whereDate('created_at', '<=', $this->sampai)
                ->orderBy('invoices.id', 'DESC')
                ->get();
        } elseif ($this->status <> 'semua' && $this->status <> '' && $this->dari <> '' && $this->sampai <> '') {
            $invoice = Invoice::select('invoices.*')
                ->where('invoices.status', $this->status)
                ->whereDate('created_at', '>=', $this->dari)
                ->whereDate('created_at', '<=', $this->sampai)
                ->orderBy('invoices.id', 'DESC')
                ->get();
        } else {
            $invoice = Invoice::select('invoices.*')
                ->orderBy('invoices.id', 'DESC')
                ->get();
        }

        return view('admin.pesanan.excel', compact('setting', 'invoice'));
    }
}
