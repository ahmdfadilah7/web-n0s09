@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.pesanan') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Pesanan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.pesanan') }}">Pesanan</a></div>
            <div class="breadcrumb-item active">Tambah</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Pesanan</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['admin.pesanan.store'], 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Invoice</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="kode_invoice" class="form-control" value="{{ $kode_invoice }}" readonly>
                            <i class="text-danger">{{ $errors->first('kode_invoice') }}</i>
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
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Produk</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="harga_produk" id="hargaProduk" class="form-control" readonly>
                            <i class="text-danger">{{ $errors->first('harga_produk') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="jumlah" id="jumlah" class="form-control" onchange="myJumlah()">
                            <i class="text-danger">{{ $errors->first('jumlah') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="total" id="total" class="form-control" readonly>
                            <i class="text-danger">{{ $errors->first('total') }}</i>
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
            var url = "{{ url('admin/pesanan/getProduk') }}/"+id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#hargaProduk').val(data.harga_jual);
                }
            });
        }

        function myJumlah(){
            var jumlah = document.getElementById('jumlah').value;
            var harga = document.getElementById('hargaProduk').value;
            var total = jumlah  * harga;
            $('#total').val(total)
        }
    </script>

@endsection