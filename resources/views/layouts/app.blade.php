<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $setting->nama_website }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ url($setting->favicon) }}">

    {{-- Css --}}
    @yield('css')
    {{-- End Css --}}

    @yield('script_css')

</head>

<body>
    <div class="page-holder">
        {{-- Header --}}
        @include('layouts.partials.header')
        {{-- End Header --}}

        {{-- Content --}}
        @yield('content')
        {{-- End Content --}}

        <!--  Modal -->
        <div class="modal fade" id="productView" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content overflow-hidden border-0">
                    <button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body p-0">
                        <div class="row align-items-stretch">
                            <div class="col-lg-6 p-lg-0">
                                <img src="" id="gambarBarang" class="w-100">
                                {{-- <a class="glightbox product-view d-block h-100 bg-cover bg-center"
                                    style="background: url(img/product-5.jpg)" href="img/product-5.jpg"
                                    data-gallery="gallery1" data-glightbox="Red digital smartwatch">
                                </a>
                                <a class="glightbox d-none" href="img/product-5-alt-1.jpg" data-gallery="gallery1"
                                    data-glightbox="Red digital smartwatch">
                                </a>
                                <a class="glightbox d-none" href="img/product-5-alt-2.jpg" data-gallery="gallery1"
                                    data-glightbox="Red digital smartwatch">
                                </a> --}}
                            </div>
                            <div class="col-lg-6">
                                <div class="p-4 my-md-4">
                                    <h2 class="h4" id="namaBarang"></h2>
                                    <p class="text-muted" id="hargaBarang"></p>
                                    <p class="text-muted">Stok : <span id="stokBarang"></span></p>
                                    <div class="text-sm mb-4" id="deskBarang"></div>

                                    {!! Form::open(['method' => 'post', 'route' => ['keranjang.store']]) !!}
                                        <input type="hidden" name="produk_id" id="produkId">
                                        <input type="hidden" name="harga_produk" id="hargaProduk">
                                        <div class="row align-items-stretch mb-4 gx-0">
                                            <div class="col-sm-7">
                                                <div class="border d-flex align-items-center justify-content-between py-1 px-3">
                                                    <span class="small text-uppercase text-gray mr-4 no-select">Jumlah</span>
                                                    <div class="quantity">
                                                        <button type="button" class="dec-btn p-0">
                                                            <i class="fas fa-caret-left"></i>
                                                        </button>
                                                        <input class="form-control border-0 shadow-0 p-0" name="jumlah" type="text" value="1">
                                                        <button type="button" class="inc-btn p-0">
                                                            <i class="fas fa-caret-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <button type="submit" class="btn btn-dark btn-sm w-100 h-100 d-flex align-items-center justify-content-center px-0">
                                                    Tambah Keranjang
                                                </button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @include('layouts.partials.footer')
        {{-- End Footer --}}

        {{-- Js --}}
        @yield('js')
        {{-- End Js --}}

        {{-- Script --}}
        @yield('script')
        {{-- End Script --}}

    </div>
</body>

</html>
