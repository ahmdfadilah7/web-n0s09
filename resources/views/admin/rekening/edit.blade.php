@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.rekening') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Rekening</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.rekening') }}">Rekening</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Rekening</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($rekening, ['method' => 'post', 'route' => ['admin.rekening.update', $rekening->id], 'enctype' => 'multipart/form-data']) !!}
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Rekening</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="nama_rekening" class="form-control" value="{{ $rekening->nama_rekening }}">
                            <i class="text-danger">{{ $errors->first('nama_rekening') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Rekening</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="no_rekening" class="form-control" value="{{ $rekening->no_rekening }}">
                            <i class="text-danger">{{ $errors->first('no_rekening') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="bank" class="form-control" value="{{ $rekening->bank }}">
                            <i class="text-danger">{{ $errors->first('bank') }}</i>
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