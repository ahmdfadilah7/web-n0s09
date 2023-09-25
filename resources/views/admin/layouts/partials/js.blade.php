@section('js')

<!-- General JS Scripts -->
<script src="{{ asset('assets/admin/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/popper.js') }}"></script>
<script src="{{ asset('assets/admin/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/admin/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('assets/admin/modules/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/chart.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/admin/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/admin/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('assets/admin/js/page/index.js') }}"></script>
<script src="{{ asset('assets/admin/js/page/features-post-create.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
<script src="{{ asset('assets/admin/js/custom.js') }}"></script>
<script>
    @if (Session::has('berhasil'))
        iziToast.success({
            title: 'Success',
            message: '{{ session("berhasil") }}',
            position: 'topRight'
        });
    @endif

    @if (Session::has('errors'))
        @foreach ($errors->all() as $errors)
        iziToast.error({
            title: 'Error',
            message: '{{ $errors }}',
            position: 'topRight'
        });
        @endforeach
    @endif
</script>

@endsection