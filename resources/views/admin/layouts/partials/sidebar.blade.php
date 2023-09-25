<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ url($setting->logo) }}" width="50">
                <p>{{ $setting->nama_website }}</p>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ url($setting->logo) }}" width="50"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li @if(Request::segment(2)=='dashboard') class="active" @endif><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">Transaksi</li>
            <li @if(Request::segment(2)=='pesanan' && Request::segment(3)!='selesai' && Request::segment(3)!='batal') class="active" @endif><a class="nav-link" href="{{ route('admin.pesanan') }}"><i class="fas ion-navicon-round"></i> <span>Pesanan</span></a></li>
            <li @if(Request::segment(2)=='pesanan' && Request::segment(3)=='selesai') class="active" @endif><a class="nav-link" href="{{ route('admin.pesanan.selesai') }}"><i class="fas ion-navicon-round"></i> <span>Pesanan Selesai</span></a></li>
            <li @if(Request::segment(2)=='pesanan' && Request::segment(3)=='batal') class="active" @endif><a class="nav-link" href="{{ route('admin.pesanan.batal') }}"><i class="fas ion-navicon-round"></i> <span>Pesanan Dibatalkan</span></a></li>
            <li @if(Request::segment(2)=='pembelian') class="active" @endif><a class="nav-link" href="{{ route('admin.pembelian') }}"><i class="fas ion-navicon-round"></i> <span>Pembelian</span></a></li>

            <li class="menu-header">Page</li>
            <li @if(Request::segment(2)=='kategoriproduk') class="active" @endif><a class="nav-link" href="{{ route('admin.kategoriproduk') }}"><i class="fas ion-navicon-round"></i> <span>Kategori Produk</span></a></li>
            <li @if(Request::segment(2)=='produk') class="active" @endif><a class="nav-link" href="{{ route('admin.produk') }}"><i class="fas ion-navicon-round"></i> <span>Produk</span></a></li>

            @if(Auth::guard('admin')->user()->role == 'Admin')
                <li @if(Request::segment(2)=='rekening') class="active" @endif><a class="nav-link" href="{{ route('admin.rekening') }}"><i class="fas ion-navicon-round"></i> <span>Rekening</span></a></li>
                <li @if(Request::segment(2)=='jasakirim') class="active" @endif><a class="nav-link" href="{{ route('admin.jasakirim') }}"><i class="fas ion-navicon-round"></i> <span>Jasa Kirim</span></a></li>
            @endif
            
            
            @if(Auth::guard('admin')->user()->role == 'Admin')
                <li class="menu-header">Pengguna</li>
                <li @if(Request::segment(2)=='pelanggan') class="active" @endif><a class="nav-link" href="{{ route('admin.pelanggan') }}"><i class="fas fa-users"></i> <span>Pelanggan</span></a></li>
                <li @if(Request::segment(2)=='pegawai') class="active" @endif><a class="nav-link" href="{{ route('admin.pegawai') }}"><i class="fas fa-users"></i> <span>Pegawai</span></a></li>
                <li @if(Request::segment(2)=='administrator') class="active" @endif><a class="nav-link" href="{{ route('admin.administrator') }}"><i class="fas fa-users"></i> <span>Administrator</span></a></li>
                
                <li class="menu-header">Settings</li>
                <li @if(Request::segment(2)=='setting') class="active" @endif><a href="{{ route('admin.setting') }}" class="nav-link"><i class="fas ion-ios-gear"></i> <span>Setting Website</span></a></li>
            @endif
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout', Auth::guard('admin')->user()->role) }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </aside>
</div>
