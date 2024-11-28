@extends('front.layouts.app')

@section('main')

    <!-- Header Start -->
    <div class="container-xxl py-5 bg-dark page-header mb-5" style="background-image:url('{{ asset('assets/images/banner-1.jpg') }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
        <div class="container my-5 pt-5 pb-4 text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Terms and Conditions</h1>
            <p class="text-white fs-5">Please read our terms and conditions carefully before using this website.</p>
        </div>
    </div>
    <!-- Header End -->

    <!-- Terms Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Row 1: Image on the Right, Text on the Left -->
            <div class="row g-5 mb-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="row g-0 about-bg rounded overflow-hidden shadow-lg">
                        <div class="col-12 text-start">
                            <img class="img-fluid w-100 rounded" src="{{ asset('assets/images/banner-1.jpg') }}" alt="Image 1" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="mb-4 text-primary">Welcome to TechHive!</h1>
                    <p class="mb-4 fs-5 text-muted">By using our website, you agree to comply with and be bound by the following terms and conditions. If you do not agree with these terms, please do not use this site.</p>
                    <h4>Effective Date: November 28, 2024</h4>
                </div>
            </div>

            <!-- Row 2: Image on the Left, Text on the Right -->
            <div class="row g-5 mb-5">
                <div class="col-lg-6 wow fadeIn p-5" data-wow-delay="0.1s">
                    <h3>1. Who Can Use TechHive</h3>
                    <p>You must be 18 years or older to use this website.</p>
                    <p>This website is intended for IT professionals, technology enthusiasts, and anyone interested in technology-related services.</p>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="row g-0 about-bg rounded overflow-hidden shadow-lg">
                        <div class="col-12 text-start">
                            <img class="img-fluid w-100 rounded" src="{{ asset('assets/images/banner-2.jpg') }}" alt="Image 2" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 3: Image on the Right, Text on the Left -->
            <div class="row g-5 mb-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="row g-0 about-bg rounded overflow-hidden shadow-lg">
                        <div class="col-12 text-start">
                            <img class="img-fluid w-100 rounded" src="{{ asset('assets/images/banner3.jpg') }}" alt="Image 3" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn p-5" data-wow-delay="0.5s">
                    <h3>2. Using TechHive</h3>
                    <p>By using TechHive, you agree to:</p>
                    <ul class="mb-4 text-muted">
                        <li><i class="fa fa-check text-primary me-3"></i>Use the site responsibly and in accordance with all applicable laws.</li>
                        <li><i class="fa fa-check text-primary me-3"></i>Not share harmful, illegal, or offensive content.</li>
                        <li><i class="fa fa-check text-primary me-3"></i>Not attempt to hack, alter, or disrupt the site’s operations.</li>
                    </ul>
                    <p>We reserve the right to suspend or block your access if you misuse the site.</p>
                </div>
            </div>

            <!-- Row 4: Image on the Left, Text on the Right -->
            <div class="row g-5 mb-5">
                <div class="col-lg-6 wow fadeIn p-5" data-wow-delay="0.1s">
                    <h3>3. Your Account</h3>
                    <p>If you create an account with us, you agree to:</p>
                    <ul class="mb-4 text-muted">
                        <li><i class="fa fa-check text-primary me-3"></i>Keep your login credentials secure.</li>
                        <li><i class="fa fa-check text-primary me-3"></i>Provide accurate and up-to-date information when signing up.</li>
                    </ul>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="row g-0 about-bg rounded overflow-hidden shadow-lg">
                        <div class="col-12 text-start">
                            <img class="img-fluid w-100 rounded" src="{{ asset('assets/images/banner4.jpg') }}" alt="Image 4" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add more rows as needed following the same pattern -->

        </div>
    </div>
    <!-- Terms End -->

@endsection

@section('customJs')
@endsection
