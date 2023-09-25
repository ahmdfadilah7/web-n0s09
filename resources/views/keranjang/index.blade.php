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
                        <h1 class="h2 text-uppercase mb-0">Keranjang</h1>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <div class="d-flex justify-content-between">
                <h2 class="h5 text-uppercase mb-4">Keranjang Belanja</h2>
                @if($invoice <> '')
                    <h2 class="h5 text-uppercase mb-4">{{ $invoice->kode_invoice }}</h2>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <!-- CART TABLE-->
                    <div class="table-responsive mb-4">
                        <table class="table text-nowrap">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 p-3" scope="col">
                                        <strong class="text-sm text-uppercase">Produk</strong>
                                    </th>
                                    <th class="border-0 p-3" scope="col"> 
                                        <strong class="text-sm text-uppercase">Harga</strong>
                                    </th>
                                    <th class="border-0 p-3" scope="col"> 
                                        <strong class="text-sm text-uppercase">Jumlah</strong>
                                    </th>
                                    <th class="border-0 p-3" scope="col"> 
                                        <strong class="text-sm text-uppercase">Total</strong>
                                    </th>
                                    <th class="border-0 p-3" scope="col"> 
                                        <strong class="text-sm text-uppercase"></strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border-0">

                                @if($invoice <> '')
                                    @foreach($transaksi_detail as $row)
                                        @php
                                            $total[] = $row->total
                                        @endphp
                                        <tr>
                                            <th class="ps-0 py-3 border-light" scope="row">
                                                <div class="d-flex align-items-center">
                                                    <a class="reset-anchor d-block animsition-link" href="{{ route('shop.detail', $row->slug) }}">
                                                        <img src="{{ url($row->gambar) }}" alt="..." width="70" />
                                                    </a>
                                                    <div class="ms-3">
                                                        <strong class="h6">
                                                            <a class="reset-anchor animsition-link" href="{{ route('shop.detail', $row->slug) }}">
                                                                {{ $row->nama }}
                                                            </a>
                                                        </strong>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="p-3 align-middle border-light">
                                                <p class="mb-0 small">{{ AllHelper::rupiah($row->harga_jual) }}</p>
                                            </td>
                                            <td class="p-3 align-middle border-light">
                                                {!! Form::open(['method' => 'post', 'route' => ['keranjang.updatejumlah', $row->id]]) !!}
                                                    <input type="hidden" name="harga_produk" value="{{ $row->harga_jual }}">
                                                    <div class="border d-flex align-items-center justify-content-between px-3 mb-2">
                                                        <span class="small text-uppercase text-gray headings-font-family">Jumlah</span>
                                                        <div class="quantity">
                                                            <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                                                            <input name="jumlah" class="form-control form-control-sm border-0 shadow-0 p-0"
                                                                type="text" value="{{ $row->jumlah }}" />
                                                            <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                                                        </div>
                                                    </div>
                                                {!! Form::close() !!}
                                            </td>
                                            <td class="p-3 align-middle border-light">
                                                <p class="mb-0 small">{{ AllHelper::rupiah($row->total) }}</p>
                                            </td>
                                            <td class="p-3 align-middle border-light">
                                                <a class="reset-anchor" href="{{ route('keranjang.delete', $row->id) }}">
                                                    <i class="fas fa-trash-alt small text-muted"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- CART NAV-->
                    <div class="bg-light px-4 py-3">
                        <div class="row align-items-center text-center">
                            <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                                    href="{{ route('shop') }}"><i class="fas fa-long-arrow-alt-left me-2"> </i>Lanjut Belanja</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ORDER TOTAL-->
                @if($invoice <> '')
                    <div class="col-lg-4">
                        <div class="card border-0 rounded-0 p-lg-4 bg-light">
                            <div class="card-body">
                                <h5 class="text-uppercase mb-4">Total Keranjang</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex align-items-center justify-content-between"><strong
                                            class="text-uppercase small font-weight-bold">Subtotal</strong><span
                                            class="text-muted small">{{ AllHelper::rupiah(array_sum($total)) }}</span></li>
                                    <li class="border-bottom my-2"></li>
                                    <li class="d-flex align-items-center justify-content-between mb-4">
                                        <strong class="text-uppercase small font-weight-bold">Total</strong>
                                        <span>{{ AllHelper::rupiah(array_sum($total)) }}</span>
                                    </li>
                                    <li>
                                        <a class="btn btn-outline-dark d-block w-100" href="{{ route('keranjang.checkout', $invoice->kode_invoice) }}">
                                            Procceed to checkout
                                            <i class="fas fa-long-arrow-alt-right ms-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
