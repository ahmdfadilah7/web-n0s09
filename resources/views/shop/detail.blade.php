@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <!-- PRODUCT SLIDER-->
                    <div class="row m-sm-0">
                        <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                            <div class="swiper product-slider-thumbs">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide h-auto swiper-thumb-item mb-3">
                                        <img class="w-100" src="{{ url($produk->gambar) }}" alt="...">
                                    </div>
                                    @if($produk->gambar_1 <> '')                                        
                                        <div class="swiper-slide h-auto swiper-thumb-item mb-3">
                                            <img class="w-100" src="{{ url($produk->gambar_1) }}" alt="...">
                                        </div>
                                    @endif
                                    @if($produk->gambar_2 <> '')                                        
                                        <div class="swiper-slide h-auto swiper-thumb-item mb-3">
                                            <img class="w-100" src="{{ url($produk->gambar_2) }}" alt="...">
                                        </div>
                                    @endif
                                    @if($produk->gambar_3 <> '')                                        
                                        <div class="swiper-slide h-auto swiper-thumb-item mb-3">
                                            <img class="w-100" src="{{ url($produk->gambar_3) }}" alt="...">
                                        </div>
                                    @endif
                                    @if($produk->gambar_4 <> '')                                        
                                        <div class="swiper-slide h-auto swiper-thumb-item mb-3">
                                            <img class="w-100" src="{{ url($produk->gambar_4) }}" alt="...">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 order-1 order-sm-2">
                            <div class="swiper product-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide h-auto">
                                        <a class="glightbox product-view" href="{{ url($produk->gambar) }}" data-gallery="gallery2" data-glightbox="{{ $produk->nama }}">
                                            <img class="w-100" src="{{ url($produk->gambar) }}" alt="...">
                                        </a>
                                    </div>
                                    @if($produk->gambar_1 <> '')
                                        <div class="swiper-slide h-auto">
                                            <a class="glightbox product-view" href="{{ url($produk->gambar_1) }}" data-gallery="gallery2" data-glightbox="{{ $produk->nama }}">
                                                <img class="w-100" src="{{ url($produk->gambar_1) }}" alt="...">
                                            </a>
                                        </div>
                                    @endif
                                    @if($produk->gambar_2 <> '')
                                        <div class="swiper-slide h-auto">
                                            <a class="glightbox product-view" href="{{ url($produk->gambar_2) }}" data-gallery="gallery2" data-glightbox="{{ $produk->nama }}">
                                                <img class="w-100" src="{{ url($produk->gambar_2) }}" alt="...">
                                            </a>
                                        </div>
                                    @endif
                                    @if($produk->gambar_3 <> '')
                                        <div class="swiper-slide h-auto">
                                            <a class="glightbox product-view" href="{{ url($produk->gambar_3) }}" data-gallery="gallery2" data-glightbox="{{ $produk->nama }}">
                                                <img class="w-100" src="{{ url($produk->gambar_3) }}" alt="...">
                                            </a>
                                        </div>
                                    @endif
                                    @if($produk->gambar_4 <> '')
                                        <div class="swiper-slide h-auto">
                                            <a class="glightbox product-view" href="{{ url($produk->gambar_4) }}" data-gallery="gallery2" data-glightbox="{{ $produk->nama }}">
                                                <img class="w-100" src="{{ url($produk->gambar_4) }}" alt="...">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT DETAILS-->
                <div class="col-lg-6">
                    <h1>{{ $produk->nama }}</h1>
                    <p class="text-muted lead">{{ AllHelper::rupiah($produk->harga_jual) }}</p>
                    {!! Form::open(['method' => 'post', 'route' => ['keranjang.store']]) !!}
                        <div class="row align-items-stretch mb-4">
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="harga_produk" value="{{ $produk->harga_jual }}">
                            <div class="col-sm-5 pr-sm-0">
                                <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
                                    <span class="small text-uppercase text-gray mr-4 no-select">Jumlah</span>
                                    <div class="quantity">
                                        <button type="button" class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                                        <input class="form-control border-0 shadow-0 p-0" name="jumlah" type="text" value="1">
                                        <button type="button" class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 pl-sm-0">
                                <button type="submit" class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center">Add to cart</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <ul class="list-unstyled small d-inline-block">
                        <li class="px-3 py-2 mb-1 bg-white">
                            <strong class="text-uppercase">Stok :</strong>
                            <span class="ms-2 text-muted">{{ $produk->stok }}</span>
                        </li>
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">Kategori :</strong>
                            <a class="reset-anchor ms-2" href="{{ route('shop.kategori', str_replace(' ', '-', $produk->kategori)) }}">{{ $produk->kategori }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- DETAILS TABS-->
            <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-uppercase active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                        Description
                    </a>
                </li>
            </ul>
            <div class="tab-content mb-5" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <h6 class="text-uppercase">Deskripsi Produk</h6>
                        <div class="text-muted text-sm mb-0">
                            {!! $produk->deskripsi !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- RELATED PRODUCTS-->
            <h2 class="h5 text-uppercase mb-4">Produk Lainnya</h2>
            <div class="row">
                <!-- PRODUCT-->
                @foreach($produk_lain as $row)                    
                    <div class="col-lg-3 col-sm-6">
                        <div class="product text-center skel-loader">
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
        </div>
    </section>
@endsection
