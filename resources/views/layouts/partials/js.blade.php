@section('js')

<!-- JavaScript files-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/nouislider/nouislider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('assets/js/front.js') }}"></script>
<script>
    @if(Session::has('berhasil'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true,
    }
            toastr.success("{{ session('berhasil') }}");
    @endif
    
    @if(Session::has('errors'))
    toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        @foreach ($errors->all() as $errors)
            toastr.error("{{ $errors }}");
        @endforeach
    @endif
    
    @if(Session::has('warning'))
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.warning("{{ session('warning') }}");
    @endif

    function get_produk(id) {
        var url = '{{ url("get_produk") }}/'+id
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#productView').modal('show')
                $('#produkId').val(data.id_produk)
                $('#namaBarang').html(data.nama_produk)                
                $('#stokBarang').html(data.stok_produk)
                $('#deskBarang').html(data.deskripsi_produk)
                $('#hargaBarang').html(data.harga_barang)
                $('#hargaProduk').val(data.harga_produk)
                document.getElementById("gambarBarang").src = data.gambar_produk;
                console.log(data)
            }
        });
    }    

    function myPengiriman() {
        var id = document.getElementById('pengiriman').value;
        var id2 = document.getElementById('kodeInvoice').value;
        var url = "{{ url('keranjang/pengiriman') }}/"+id+'/'+id2;
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#ongkir').html(data.ongkir);    
                $('#totalInvoice').html(data.total);
                $('#totalInvoiceClear').val(data.totalclear);
            }
        });
    }
</script>
<!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
    crossorigin="anonymous">

@endsection