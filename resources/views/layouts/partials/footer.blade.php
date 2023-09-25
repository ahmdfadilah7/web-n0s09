<footer class="bg-dark text-white">
    <div class="container py-4">
        <div class="row py-5">
            <div class="col-md-4 mb-3 mb-md-0">
                <h6 class="text-uppercase mb-3">{{ $setting->nama_website }}</h6>
                <div>
                    {!! $setting->desk_singkat !!}
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h6 class="text-uppercase mb-3">Company</h6>
                <ul class="list-unstyled mb-0">
                    <li><a class="footer-link" href="#!">What We Do</a></li>
                    <li><a class="footer-link" href="#!">Available Services</a></li>
                    <li><a class="footer-link" href="#!">Latest Posts</a></li>
                    <li><a class="footer-link" href="#!">FAQs</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-uppercase mb-3">Social media</h6>
                <ul class="list-unstyled mb-0">
                    <li><a class="footer-link" href="{{ $setting->facebook }}" target="_blank">Facebook</a></li>
                    <li><a class="footer-link" href="{{ $setting->twitter }}" target="_blank">Twitter</a></li>
                    <li><a class="footer-link" href="{{ $setting->instagram }}" target="_blank">Instagram</a></li>
                    <li><a class="footer-link" href="{{ $setting->youtube }}" target="_blank">YouTube</a></li>
                </ul>
            </div>
        </div>
        <div class="border-top pt-4" style="border-color: #1d1d1d !important">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-muted mb-0">&copy; {{ date('Y') }} All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small text-muted mb-0">
                        <a class="text-white reset-anchor" href="{{ route('home') }}">{{ $setting->nama_website }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>