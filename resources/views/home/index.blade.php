@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

<!-- HERO SECTION-->
<div class="container">
    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center"
        style="background: url({{ url($setting->gambar_header) }})">
        <div class="container py-5">
            <div class="row px-4 px-lg-5">
                <div class="col-lg-6">
                    <p class="text-muted small text-uppercase mb-2">{{ $setting->nama_website }}</p>
                    <h1 class="h2 text-uppercase mb-3">{{ $setting->judul_header }}</h1>
                    <a class="btn btn-dark" href="{{ route('shop') }}">Lihat Produk</a>
                </div>
            </div>
        </div>
    </section>
    <!-- CATEGORIES SECTION-->
    <section class="pt-5">
        <header class="text-center">
            <p class="small text-muted small text-uppercase mb-1">{{ $setting->nama_website }}</p>
            <h2 class="h5 text-uppercase mb-4">Kategori Produk</h2>
        </header>
        <div class="row">

            @foreach ($kategori as $row)                
                <div class="col-md-4">
                    <a class="category-item" href="{{ route('shop.kategori', str_replace(' ', '-', $row->kategori)) }}">
                        <img class="w-100" src="{{ url($row->gambar) }}" alt="" />
                        <strong class="category-item-title">{{ $row->kategori }}</strong>
                    </a>
                </div>
            @endforeach
            
        </div>
    </section>
    <!-- TRENDING PRODUCTS-->
    <section class="py-5">
        <header>
            <p class="small text-muted small text-uppercase mb-1">{{ $setting->nama_website }}</p>
            <h2 class="h5 text-uppercase mb-4">Produk</h2>
        </header>
        <div class="row">

            <!-- PRODUCT-->
            @foreach($produk as $row)                
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="product text-center">
                        <div class="position-relative mb-3">
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
                                    <li class="list-inline-item me-0">
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
    </section>
    
    
</div>

@endsection