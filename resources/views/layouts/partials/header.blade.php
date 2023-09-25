<!-- navbar-->
<header class="header bg-white">
    <div class="container px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ url($setting->logo) }}" class="img-fluid">
                <span class="fw-bold text-uppercase text-dark">{{ $setting->nama_website }}</span>
            </a>
            <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1)=='home' || Request::segment(1) == '') active @endif" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1)=='shop') active @endif" href="{{ route('shop') }}">Shop</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1)=='keranjang') active @endif" href="{{ route('keranjang') }}">
                            <i class="fas fa-dolly-flatbed me-1 text-gray"></i>
                            Keranjang
                            <small class="text-gray fw-normal">({{ $transaksi }})</small>
                        </a>
                    </li>
                    @if(Auth::guard('pelanggan')->user() <> '')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user me-1 text-gray fw-normal"></i>
                                {{ Auth::guard('pelanggan')->user()->name }}
                            </a>
                            <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown">
                                <a class="dropdown-item border-0 transition-link" href="{{ route('profile') }}">Profile</a>
                                <a class="dropdown-item border-0 transition-link" href="{{ route('pesanan') }}">Pesanan</a>
                                <a class="dropdown-item border-0 transition-link" href="{{ route('logout', Auth::guard('pelanggan')->user()->role) }}">Logout</a></div>
                            </li>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"> <i class="fas fa-user me-1 text-gray fw-normal"></i>Login</a></li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>