@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.setting') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Setting Website</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.setting') }}">Setting Website</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Setting Website</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($setting, ['method' => 'post', 'route' => ['admin.setting.update', $setting->id], 'enctype' => 'multipart/form-data']) !!}
                    @method('PUT')
                    @csrf
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Website</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="nama_website" class="form-control" value="{{ $setting->nama_website }}">
                            <i class="text-danger">{{ $errors->first('nama_website') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
                            <i class="text-danger">{{ $errors->first('email') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telepon</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="no_telp" class="form-control" value="{{ $setting->no_telp }}">
                            <i class="text-danger">{{ $errors->first('no_telp') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea name="alamat" class="form-control summernote-simple" id="alamat" rows="10">{{ $setting->alamat }}</textarea>
                            <i class="text-danger">{{ $errors->first('alamat') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi Singkat</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea name="desk_singkat" class="form-control summernote-simple" id="alamat" rows="10">{{ $setting->desk_singkat }}</textarea>
                            <i class="text-danger">{{ $errors->first('desk_singkat') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Link Facebook</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="facebook" class="form-control" value="{{ $setting->facebook }}">
                            <i class="text-danger">{{ $errors->first('facebook') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Link Twitter</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="twitter" class="form-control" value="{{ $setting->twitter }}">
                            <i class="text-danger">{{ $errors->first('twitter') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Link Instagram</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="instagram" class="form-control" value="{{ $setting->instagram }}">
                            <i class="text-danger">{{ $errors->first('instagram') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Link Youtube</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="youtube" class="form-control" value="{{ $setting->youtube }}">
                            <i class="text-danger">{{ $errors->first('youtube') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul Header</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="judul_header" class="form-control" value="{{ $setting->judul_header }}">
                            <i class="text-danger">{{ $errors->first('judul_header') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar Header Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                <img src="{{ url($setting->gambar_header) }}" class="w-100">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar Header</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview5" class="image-preview">
                                <label for="image-upload5" id="image-label5">Choose File</label>
                                <input type="file" name="gambar_header" id="image-upload5" />
                            </div>
                            <i class="text-danger">{{ $errors->first('gambar_header') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                <img src="{{ url($setting->logo) }}" class="w-100">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="logo" id="image-upload" />
                            </div>
                            <i class="text-danger">{{ $errors->first('logo') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Favicon Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                <img src="{{ url($setting->favicon) }}" class="w-100">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Favicon</label>
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview2" class="image-preview">
                                <label for="image-upload2" id="image-label2">Choose File</label>
                                <input type="file" name="favicon" id="image-upload2" />
                            </div>
                            <i class="text-danger">{{ $errors->first('favicon') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Background Login Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                @if($setting->bg_login <> '')
                                    <img src="{{ url($setting->bg_login) }}" class="w-100">
                                @else
                                    <i class="text-danger">Belum ada gambar</i>                                
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Background Login</label>
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview3" class="image-preview">
                                <label for="image-upload3" id="image-label3">Choose File</label>
                                <input type="file" name="bg_login" id="image-upload3" />
                            </div>
                            <i class="text-danger">{{ $errors->first('bg_login') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Background Register Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                @if($setting->bg_register <> '')
                                    <img src="{{ url($setting->bg_register) }}" class="w-100">
                                @else
                                    <i class="text-danger">Belum ada gambar</i>                                
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Background Register</label>
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview4" class="image-preview">
                                <label for="image-upload4" id="image-label4">Choose File</label>
                                <input type="file" name="bg_register" id="image-upload4" />
                            </div>
                            <i class="text-danger">{{ $errors->first('bg_register') }}</i>
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