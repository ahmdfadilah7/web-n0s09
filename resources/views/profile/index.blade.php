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
                    <h1 class="h2 text-uppercase mb-0">Profile</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                @if(Auth::guard('pelanggan')->user()->profile->foto <> '')
                    <img src="{{ url(Auth::guard('pelanggan')->user()->profile->foto) }}" alt="" class="w-100">
                @else
                    <img src="" alt="{{ $setting->nama_website }}">
                @endif
            </div>
            <div class="col-md-8 col-sm-12">
                <table>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">Nama Lengkap</td>
                        <td>:</td>
                        <th><span class="h5 text-uppercase text-black">{{ Auth::guard('pelanggan')->user()->name }}</span></th>
                    </tr>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">Tempat Lahir</td>
                        <td>:</td>
                        <th><span class="h5 text-uppercase text-black">{{ Auth::guard('pelanggan')->user()->profile->tmpt_lahir }}</span></th>
                    </tr>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">Tanggal Lahir</td>
                        <td>:</td>
                        <th><span class="h5 text-uppercase text-black">{{ date('d M Y', strtotime(Auth::guard('pelanggan')->user()->profile->tgl_lahir)) }}</span></th>
                    </tr>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">Jenis Kelamin</td>
                        <td>:</td>
                        <th><span class="h5 text-uppercase text-black">@if(Auth::guard('pelanggan')->user()->profile->jns_kelamin == 'L') Laki - Laki @else Perempuan @endif</span></th>
                    </tr>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">Alamat</td>
                        <td>:</td>
                        <th><span class="h5 text-uppercase text-black">{!! Auth::guard('pelanggan')->user()->profile->alamat !!}</span></th>
                    </tr>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">Email</td>
                        <td>:</td>
                        <th><span class="h5 text-black">{{ Auth::guard('pelanggan')->user()->email }}</span></th>
                    </tr>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">No Telepon</td>
                        <td>:</td>
                        <th><span class="h5 text-black">{{ Auth::guard('pelanggan')->user()->profile->no_telp }}</span></th>
                    </tr>
                    <tr>
                        <td class="small text-muted small text-uppercase mb-1">Username</td>
                        <td>:</td>
                        <th><span class="h5 text-black">{{ Auth::guard('pelanggan')->user()->username }}</span></th>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{ route('profile.edit', Auth::guard('pelanggan')->user()->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profile</a>
                        </td>
                    </tr>
                </table>                
            </div>
        </div>
    </section>
</div>
@endsection