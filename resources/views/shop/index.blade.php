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
                        <h1 class="h2 text-uppercase mb-0">Shop</h1>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shop</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <div class="container p-0">
                <div class="row">
                    <!-- SHOP SIDEBAR-->
                    <div class="col-lg-3 order-2 order-lg-1">
                        <h5 class="text-uppercase mb-4">Kategori Produk</h5>
                        <div class="py-2 px-4 @if(Request::segment(1)=='shop' && Request::segment(3)=='' || Request::segment(3)=='semua') bg-dark @else bg-light @endif text-white mb-3">
                            <a href="{{ route('shop.kategori', 'semua') }}">
                                <strong class="small text-uppercase fw-bold">Semua</strong>
                            </a>
                        </div>

                        @foreach($kategori as $row)                            
                            <div class="py-2 px-4 @if(Request::segment(1)=='shop' && Request::segment(3)==str_replace(' ', '-',$row->kategori)) bg-dark @else bg-light @endif text-white mb-3">
                                <a href="{{ route('shop.kategori', str_replace(' ', '-',$row->kategori)) }}">
                                    <strong class="small text-uppercase fw-bold">{{ $row->kategori }}</strong>
                                </a>
                            </div>
                        @endforeach

                    </div>
                    <!-- SHOP LISTING-->
                    <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                        <div class="row">

                            <!-- PRODUCT-->
                            @foreach($produk as $row)                                
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product text-center">
                                        <div class="mb-3 position-relative">
                                            <div class="badge text-white bg-"></div>
                                            <a class="d-block" href="{{ route('shop.detail', $row->slug) }}">
                                                <img class="img-fluid w-100" src="{{ url($row->gambar) }}" alt="...">
                                            </a>
                                            <div class="product-overlay">
                                                <ul class="mb-0 list-inline">
                                                    <li class="list-inline-item m-0 p-0">
                                                        {!! Form::open(['method' => 'post', 'route' => ['keranjang.store']]) !!}
                                                            <input type="hidden" name="produk_id" value="{{ $row->id }}">
                                                            <input type="hidden" name="jumlah" value="1">
                                                            <input type="hidden" name="harga_produk" value="{{ $row->harga_jual }}">
                                                            <button class="btn btn-sm btn-dark" type="submit">Tambah Keranjang</button>
                                                        {!! Form::close() !!}
                                                    </li>
                                                    <li class="list-inline-item mr-0">
                                                        <a class="btn btn-sm btn-outline-dark" onclick="get_produk({{ $row->id }})">
                                                            <i class="fas fa-expand"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h6> <a class="reset-anchor" href="{{ route('shop.detail', $row->slug) }}">{{ $row->nama }}</a></h6>
                                        <p class="small text-muted">{{ AllHelper::rupiah($row->harga_jual) }}</p>
                                    </div>
                                </div>
                            @endforeach
                            <!-- PRODUCT-->
                            
                        </div>
                        <!-- PAGINATION-->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center justify-content-lg-end">
                                {{ $produk->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
