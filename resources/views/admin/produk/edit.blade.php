@extends('admin.layouts.app')
@include('admin.layouts.partials.css')
@include('admin.layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.produk') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Produk</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.produk') }}">Produk</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Produk</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($produk, ['method' => 'post', 'route' => ['admin.produk.update', $produk->id], 'enctype' => 'multipart/form-data']) !!}
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Produk</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}">
                            <i class="text-danger">{{ $errors->first('nama') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="kategori" class="form-control selectric">
                                <option value="">- Pilih -</option>
                                @foreach ($kategori as $row)
                                    <option value="{{ $row->id }}" @if($row->id==$produk->kategoriproduk_id) {{ 'selected' }} @endif>{{ $row->kategori }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('kategori') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea name="deskripsi" class="form-control summernote-simple" id="alamat" rows="10">{{ $produk->deskripsi }}</textarea>
                            <i class="text-danger">{{ $errors->first('deskripsi') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Modal</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        RP
                                    </div>
                                </div>
                                <input type="text" name="harga_modal" class="form-control currency" value="{{ $produk->harga_modal }}">
                            </div>
                            <i class="text-danger">{{ $errors->first('harga_modal') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Jual</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        RP
                                    </div>
                                </div>
                                <input type="text" name="harga_jual" class="form-control currency1" value="{{ $produk->harga_jual }}">
                            </div>
                            <i class="text-danger">{{ $errors->first('harga_jual') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                @if($produk->gambar <> '')
                                    <img src="{{ url($produk->gambar) }}" class="w-100">
                                @else
                                    <i class="text-danger">Belum ada gambar</i>                                
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="gambar" id="image-upload" />
                            </div>
                            <i class="text-danger">{{ $errors->first('gambar') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 1 Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                @if($produk->gambar_1 <> '')
                                    <img src="{{ url($produk->gambar_1) }}" class="w-100">
                                @else
                                    <i class="text-danger">Belum ada gambar</i>                                
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 1</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview2" class="image-preview">
                                <label for="image-upload2" id="image-label2">Choose File</label>
                                <input type="file" name="gambar_1" id="image-upload2" />
                            </div>
                            <i class="text-danger">{{ $errors->first('gambar_1') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 2 Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                @if($produk->gambar_2 <> '')
                                    <img src="{{ url($produk->gambar_2) }}" class="w-100">
                                @else
                                    <i class="text-danger">Belum ada gambar</i>                                
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 2</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview3" class="image-preview">
                                <label for="image-upload3" id="image-label3">Choose File</label>
                                <input type="file" name="gambar_2" id="image-upload3" />
                            </div>
                            <i class="text-danger">{{ $errors->first('gambar_2') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 3 Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                @if($produk->gambar_3 <> '')
                                    <img src="{{ url($produk->gambar_3) }}" class="w-100">
                                @else
                                    <i class="text-danger">Belum ada gambar</i>                                
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 3</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview4" class="image-preview">
                                <label for="image-upload4" id="image-label4">Choose File</label>
                                <input type="file" name="gambar_3" id="image-upload4" />
                            </div>
                            <i class="text-danger">{{ $errors->first('gambar_3') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 4 Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                @if($produk->gambar_4 <> '')
                                    <img src="{{ url($produk->gambar_4) }}" class="w-100">
                                @else
                                    <i class="text-danger">Belum ada gambar</i>                                
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar 4</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview5" class="image-preview">
                                <label for="image-upload5" id="image-label5">Choose File</label>
                                <input type="file" name="gambar_4" id="image-upload5" />
                            </div>
                            <i class="text-danger">{{ $errors->first('gambar_4') }}</i>
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
        var cleaveC = new Cleave('.currency', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
        var cleaveC1 = new Cleave('.currency1', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>

@endsection