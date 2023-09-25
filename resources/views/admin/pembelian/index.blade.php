@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')

    <div class="section-header">
        <h1>Pembelian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.pembelian') }}">Pembelian</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Pembelian</h4>
                    <a href="{{ route('admin.pembelian.add') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                </div>
                {!! Form::open(['method' => 'post', 'route' => ['admin.pembelian.export']]) !!}
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Dari</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="date" name="dari" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Sampai</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="date" name="sampai" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export</button>
                                <a href="{{ route('admin.pembelian.exportsemua') }}" class="btn btn-success"><i class="fas fa-file-export"></i> Export Semua</a>
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
                                    <th>Nama Supplier</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
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
                    url: "{{ route('admin.pembelian.list') }}",
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
                        data: 'nama_supplier',
                        name: 'nama_supplier'
                    },
                    {
                        data: 'nama',
                        name: 'produks.nama'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
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
