@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')

    <div class="section-header">
        <h1>Pesanan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.pesanan') }}">Pesanan</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Pesanan</h4>
                    <a href="{{ route('admin.pesanan.add') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                </div>
                {!! Form::open(['method' => 'post', 'route' => ['admin.pesanan.export']]) !!}
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Status</label>
                                <div class="col-sm-12 col-md-8">
                                    <select name="status" class="form-control selectric">
                                        <option value="">- Pilih -</option>
                                        <option value="semua">Semua</option>
                                        <option value="0">Pesanan belum dibayar</option>
                                        <option value="1">Pesanan menunggu konfirmasi</option>
                                        <option value="2">Pesanan sedang diproses</option>
                                        <option value="3">Pesanan sedang dikirim</option>
                                        <option value="4">Pesanan selesai</option>
                                        <option value="5">Pesanan dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Dari</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="date" name="dari" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Sampai</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="date" name="sampai" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export</button>
                                <a href="{{ route('admin.pesanan.exportsemua') }}" class="btn btn-success"><i class="fas fa-file-export"></i> Export Semua</a>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Kode Invoice</th>
                                    <th>Pemesan</th>
                                    <th>Produk</th>
                                    <th>Harga Produk</th>
                                    <th>Jumlah</th>
                                    <th>SubTotal</th>
                                    <th>Pengiriman</th>
                                    <th>Total Invoice</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(function() {
            $('#table-1').dataTable({
                processing: true,
                serverSide: true,
                'ordering': 'true',
                ajax: {
                    url: "{{ route('admin.pesanan.list') }}",
                    data: function(d) {}
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_invoice',
                        name: 'kode_invoice'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'produk',
                        name: 'produk'
                    },
                    {
                        data: 'harga_produk',
                        name: 'harga_produk'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'subtotal',
                        name: 'subtotal'
                    },
                    {
                        data: 'ongkir',
                        name: 'ongkir'
                    },
                    {
                        data: 'total_invoice',
                        name: 'total_invoice'
                    },
                    {
                        data: 'bukti',
                        name: 'bukti'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>

@endsection
