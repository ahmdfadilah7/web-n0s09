@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.pembelian') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Pembelian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.pembelian') }}">Pembelian</a></div>
            <div class="breadcrumb-item active">Tambah</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Pembelian</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['admin.pembelian.store'], 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Supplier</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="nama_supplier" class="form-control" value="{{ old('nama_supplier') }}">
                            <i class="text-danger">{{ $errors->first('nama_supplier') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Produk</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="produk" class="form-control selectric" id="produk" onchange="myProduk()">
                                <option value="">- Pilih -</option>
                                @foreach($produk as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('produk') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Modal</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="harga_modal" class="form-control" id="hargaModal" readonly>
                            <i class="text-danger">{{ $errors->first('harga_modal') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}">
                            <i class="text-danger">{{ $errors->first('jumlah') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function myProduk() {
            var id = document.getElementById('produk').value;
            var url = "{{ url('admin/pembelian/getProduk') }}/"+id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#hargaModal').val(data.harga_modal);
                }
            });
        }
    </script>

@endsection