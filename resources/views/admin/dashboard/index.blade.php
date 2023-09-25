@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah Penjualan</h4>
                    </div>
                    <div class="card-body">
                        {{ $jumlahpenjualan }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-warning bg-warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Penjualan</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $jual = 0;
                        @endphp
                        @foreach ($totalpenjualan as $row)
                            @php
                                $transaksi = \App\Models\Transaksi::join('produks', 'transaksis.produk_id', 'produks.id')
                                    ->where('invoice_id', $row->id)
                                    ->get();
                                $totaljual = 0;
                            @endphp
                            @foreach ($transaksi as $value)
                                @php
                                    $harga_jual = $value->harga_jual * $value->jumlah;
                                    $totaljual += $harga_jual;
                                @endphp
                            @endforeach
                            @php
                                $jual += $totaljual;
                            @endphp
                        @endforeach
                        {{ AllHelper::rupiah($jual) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-info bg-info">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Penjualan Non Omset</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $modal = 0;
                        @endphp
                        @foreach ($totalpenjualan as $row)
                            @php
                                $transaksi = \App\Models\Transaksi::join('produks', 'transaksis.produk_id', 'produks.id')
                                    ->where('invoice_id', $row->id)
                                    ->get();
                                $totalmodal = 0;
                            @endphp
                            @foreach ($transaksi as $value)
                                @php
                                    $harga_modal = $value->harga_modal * $value->jumlah;
                                    $totalmodal += $harga_modal;
                                @endphp
                            @endforeach
                            @php
                                $modal += $totalmodal;
                            @endphp
                        @endforeach
                        {{ AllHelper::rupiah($modal) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-success bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Keuntungan</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $keuntungan = $jual - $modal;
                        @endphp
                        {{ AllHelper::rupiah($keuntungan) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-danger bg-danger">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pengeluaran</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $pengeluaran = array();
                        @endphp
                        @foreach($pembelian as $row)
                            @php
                                $pengeluaran[] = $row->total;
                            @endphp
                        @endforeach
                        {{ AllHelper::rupiah(array_sum($pengeluaran)) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-success bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pendapatan</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $pendapatan = $jual - array_sum($pengeluaran);
                        @endphp
                        {{ AllHelper::rupiah($pendapatan) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pesanan</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart2" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Produk Terjual</h4>
                </div>
                <div class="card-body">
                    @foreach ($produk as $row)
                        @php
                            $jumlah = 0;
                            $transaksi = \App\Models\Transaksi::join('invoices', 'transaksis.invoice_id', 'invoices.id')
                                    ->where('invoices.status', 4)
                                    ->where('produk_id', $row->id)
                                    ->get();
                            foreach ($transaksi as $value) {
                                $jumlah += $value->jumlah;
                            }
                            
                            if ($row->stok == 0) {
                                $persen = ($jumlah/1)*100;
                            } else {
                                $persen = ($jumlah/$row->stok)*100;
                            }
                        @endphp
                        <div class="d-flex mb-4">
                            <div style="width:20%;">
                                <img src="{{ url($row->gambar) }}" class="img-fluid">
                            </div>
                            <div style="width: 80%" class="m-2">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $jumlah }}</div>
                                <div class="font-weight-bold mb-1">{{ $row->nama }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar" role="progressbar" data-width="{{ $persen }}%" aria-valuenow="{{ $row->stok }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var ctx = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    "Pesanan belum dibayar",
                    "Pesanan menunggu konfirmasi",
                    "Pesanan sedang diproses",
                    "Pesanan sedang dikirim",
                    "Pesanan selesai",
                    "Pesanan dibatalkan",
                ],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        {{ $belumbayar }},
                        {{ $menunggukonfirmasi }},
                        {{ $diproses }},
                        {{ $dikirim }},
                        {{ $selesai }},
                        {{ $batal }},
                    ],
                    borderWidth: 2,
                    backgroundColor: ['#fc544b', '#3abaf4', '#6777ef', '#ffa426 ', '#63ed7a', '#fc544b'],
                    borderColor: 'transparent',
                    borderWidth: 0,
                    pointBackgroundColor: '#999',
                    pointRadius: 4
                }]
            },
            options: {
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: true,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: {{ $jumlahpesanan }}
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: true
                        }
                    }]
                },
            }
        });
    </script>
@endsection
