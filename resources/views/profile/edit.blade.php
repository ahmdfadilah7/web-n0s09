@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('script_css')
    <style>
        /* 1.14 Image Preview */
        .image-preview,
        #callback-preview {
            width: 250px;
            height: 250px;
            border: 2px dashed #ddd;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
        }

        .image-preview input,
        #callback-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }

        .image-preview label,
        #callback-preview label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            background-color: #bdc3c7;
            width: 150px;
            height: 50px;
            font-size: 12px;
            line-height: 50px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
        }
    </style>
@endsection

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
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('profile') }}">Profile</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            {!! Form::open([
                'method' => 'post',
                'route' => ['profile.update', Auth::guard('pelanggan')->user()->id],
                'enctype' => 'multipart/form-data',
            ]) !!}
            @method('PUT')
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control"
                            value="{{ Auth::guard('pelanggan')->user()->name }}">
                        <i class="text-danger">{{ $errors->first('nama_lengkap') }}</i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ Auth::guard('pelanggan')->user()->email }}">
                        <i class="text-danger">{{ $errors->first('email') }}</i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ Auth::guard('pelanggan')->user()->profile->tmpt_lahir }}">
                        <i class="text-danger">{{ $errors->first('tempat_lahir') }}</i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ Auth::guard('pelanggan')->user()->profile->tgl_lahir }}">
                        <i class="text-danger">{{ $errors->first('tanggal_lahir') }}</i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">- Pilih -</option>
                            <option value="L" @if (Auth::guard('pelanggan')->user()->profile->jns_kelamin == 'L') selected @endif>Laki - Laki</option>
                            <option value="P" @if (Auth::guard('pelanggan')->user()->profile->jns_kelamin == 'P') selected @endif>Perempuan</option>
                        </select>
                        <i class="text-danger">{{ $errors->first('jenis_kelamin') }}</i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">No Telepon</label>
                        <input type="number" name="no_telp" class="form-control"
                            value="{{ Auth::guard('pelanggan')->user()->profile->no_telp }}">
                        <i class="text-danger">{{ $errors->first('no_telp') }}</i>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Alamat</label>
                        <textarea name="alamat" class="form-control summernote">{!! Auth::guard('pelanggan')->user()->profile->alamat !!}</textarea>
                        <i class="text-danger">{{ $errors->first('alamat') }}</i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Foto Sebelumnya</label><br>
                        @if(Auth::guard('pelanggan')->user()->profile->foto <> '')
                            <img src="{{ url(Auth::guard('pelanggan')->user()->profile->foto) }}" class="img-fluid">
                        @else
                            <img src="" class="img-fluid" alt="{{ $setting->nama_website }}">
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="foto">Foto</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="foto" id="image-upload" />
                        </div>
                        <i class="text-danger">{{ $errors->first('foto') }}</i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ Auth::guard('pelanggan')->user()->username }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control">
                        <i>*Isi jika ingin mengganti password.</i>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('profile') }}" class="btn btn-danger d-block w-100">Kembali</a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary d-block w-100">Simpan</button>
                </div>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        $('.summernote').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection
