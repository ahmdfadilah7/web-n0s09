@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')
    <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                    <div class="col-lg-6">
                        <h1 class="h2 text-uppercase mb-0">Checkout</h1>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('keranjang') }}">Keranjang</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <!-- BILLING ADDRESS-->
            <div class="d-flex justify-content-between">
                <h2 class="h5 text-uppercase mb-4">Pesanan Detail</h2>
                <h2 class="h5 text-uppercase mb-4">{{ $invoice->kode_invoice }}</h2>
            </div>
            {!! Form::open(['method' => 'post', 'route' => ['keranjang.prosesInvoice', $invoice->kode_invoice]]) !!}
            <div class="row">
                <div class="col-lg-8">
                    <div class="row gy-3">
                        <div class="col-lg-12">
                            <label class="form-label text-sm text-uppercase" for="firstName">Nama Lengkap</label>
                            <input class="form-control form-control-lg" type="text" id="firstName" value="{{ Auth::guard('pelanggan')->user()->name }}" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label text-sm text-uppercase" for="email">Email</label>
                            <input class="form-control form-control-lg" type="email" id="email" value="{{ Auth::guard('pelanggan')->user()->email }}" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label text-sm text-uppercase" for="phone">No Telepon</label>
                            <input class="form-control form-control-lg" type="text" id="phone" value="{{ Auth::guard('pelanggan')->user()->profile->no_telp }}" readonly>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label text-sm text-uppercase" for="address">Alamat</label>
                            {!! Auth::guard('pelanggan')->user()->profile->alamat !!}
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label text-sm text-uppercase" for="phone">Rekening</label>
                            <select name="rekening" class="form-control form-control-lg" id="rekening">
                                <option value="">- Pilih -</option>
                                @foreach($rekening as $row)
                                    <option value="{{ $row->id }}">{{ $row->bank.' - '.$row->no_rekening.' - '.$row->nama_rekening }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label text-sm text-uppercase" for="phone">Pengiriman</label>
                            <select name="pengiriman" class="form-control form-control-lg" id="pengiriman" onchange="myPengiriman()">
                                <option value="0">- Pilih -</option>
                                @foreach($pengiriman as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama.' - '.AllHelper::rupiah($row->ongkir) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- ORDER SUMMARY-->
                <div class="col-lg-4">
                    <div class="card border-0 rounded-0 p-lg-4 bg-light">
                        <div class="card-body">
                            <h5 class="text-uppercase mb-4">Daftar Pesanan</h5>
                            <ul class="list-unstyled mb-0">
                                @foreach($transaksi_detail as $row)
                                    @php
                                        $total[] = $row->total;
                                    @endphp
                                    <li class="d-flex align-items-center justify-content-between">
                                        <strong class="small fw-bold">{{ $row->nama }}</strong>
                                        <strong class="small fw-bold">x{{ $row->jumlah }}</strong>
                                        <span class="text-muted small">{{ AllHelper::rupiah($row->harga_jual) }}</span>
                                    </li>
                                    <li class="border-bottom my-2"></li>
                                @endforeach
                                <li class="d-flex align-items-center justify-content-between">
                                    <strong class="small fw-bold">Pengiriman</strong>
                                    <span class="text-muted small" id="ongkir">Rp0</span>
                                </li>
                                <li class="border-bottom my-2"></li>
                                <li class="d-flex align-items-center justify-content-between">
                                    <strong class="small fw-bold">Total</strong>
                                    <span class="text-muted small" id="totalInvoice">{{ AllHelper::rupiah(array_sum($total)) }}</span>
                                </li>
                            </ul>
                            <input type="hidden" name="kode_invoice" id="kodeInvoice" value="{{ $invoice->kode_invoice }}">
                            <input type="hidden" name="total_invoice" id="totalInvoiceClear" value="{{ array_sum($total) }}">
                            <button type="submit" class="btn btn-outline-dark d-block w-100">
                                Pembayaran
                                <i class="fas fa-long-arrow-alt-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection
