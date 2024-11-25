@extends('front.layouts.app')

@section('main')
    @if (!Auth::check())
        <script>
            window.location.href = "{{ route('account.login') }}";
        </script>
    @else
        <section class="section-5 bg-2">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ti-icons@0.1.2/css/themify-icons.css">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="row py-5">
                        <div class="col">
                            <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="col-md-7 col-lg-4 mb-5 mb-lg-0 wow fadeIn">
                        <div class="card border-0 shadow">
                            @include('front.account.sidebar')
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                        @include('front.message')
                        <div class="ps-lg-1-6 ps-xl-5">
                            <div class="mb-5 wow fadeIn">
                                <div class="text-start mb-4 wow fadeIn">
                                    <h2 class="h1 mb-0 text-primary">About Me</h2>
                                </div>
                                
                                <!-- Center the image with flexbox -->
                                <div class="d-flex justify-content-center mb-4">
                                    <div class="img">
                                        @if(Auth::check())
                                            @if(!empty(Auth::user()->image))
                                                <img src="{{ asset('profile_pic/thumb/'.Auth::user()->image) }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                            @else
                                                <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                {{-- Center Name --}}
                                <div class="d-flex justify-content-center align-items-center mt-3 pb-0">
                                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                </div>

                                {{-- Center Designation/Position --}}
                                <div class="d-flex justify-content-center align-items-center mt-3 pb-0 mb-4">
                                    <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation ?? 'No designation provided' }}</p>
                                </div>
                                
                                <!-- About Me Description -->
                                <div class="text-center">
                                    {!! nl2br(e(strip_tags(Auth::user()->about ?? 'No About Me provided'))) !!}
                                </div>
                            </div>                    

                            <div class="mb-5 wow fadeIn">
                                <div class="text-start mb-1-6 wow fadeIn">
                                    <h2 class="mb-0 text-primary">Education</h2>
                                </div>
                                <div class="row mt-n4">
                                    <div class="col-sm-6 col-xl-4 mt-4">
                                        <div class="card text-center border-0 rounded-3">
                                            <div class="card-body">
                                                <i class="ti-bookmark-alt icon-box medium rounded-3 mb-4"></i>
                                                <h3 class="h5 mb-3">Education</h3>
                                                <p class="mb-0">{{ Auth::user()->education ?? 'No Education provided' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 mt-4">
                                        <div class="card text-center border-0 rounded-3">
                                            <div class="card-body">
                                                <i class="ti-pencil-alt icon-box medium rounded-3 mb-4"></i>
                                                <h3 class="h5 mb-3">Career Start</h3>
                                                <p class="mb-0">{{ Auth::user()->career_start ?? 'No Career Start provided' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 mt-4">
                                        <div class="card text-center border-0 rounded-3">
                                            <div class="card-body">
                                                <i class="ti-medall-alt icon-box medium rounded-3 mb-4"></i>
                                                <h3 class="h5 mb-3">Experience</h3>
                                                <p class="mb-0">{{ Auth::user()->experience ?? 'No Experience provided' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wow fadeIn">
                                <div class="text-start mb-1-6 wow fadeIn">
                                    <h2 class="mb-0 text-primary">Certificates &amp; Other Info</h2>
                                </div>
                                <!-- Certificates & Other Info -->
                                <div class="text-center">
                                    {!! nl2br(e(strip_tags(Auth::user()->other ?? 'No Other Info provided'))) !!}
                                </div>
                                <div class="progress-style1">
                                    <div class="progress-text">
                                        <div class="row">
                                            <div class="col-6 fw-bold">Wind Turbines</div>
                                            <div class="col-6 text-end">70%</div>
                                        </div>
                                    </div>
                                    <div class="custom-progress progress rounded-3 mb-4">
                                        <div class="animated custom-bar progress-bar slideInLeft" style="width:70%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar"></div>
                                    </div>
                                    <div class="progress-text">
                                        <div class="row">
                                            <div class="col-6 fw-bold">Solar Panels</div>
                                            <div class="col-6 text-end">90%</div>
                                        </div>
                                    </div>
                                    <div class="custom-progress progress rounded-3 mb-4">
                                        <div class="animated custom-bar progress-bar bg-secondary slideInLeft" style="width:90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar"></div>
                                    </div>
                                    <div class="progress-text">
                                        <div class="row">
                                            <div class="col-6 fw-bold">Hybrid Energy</div>
                                            <div class="col-6 text-end">80%</div>
                                        </div>
                                    </div>
                                    <div class="custom-progress progress rounded-3">
                                        <div class="animated custom-bar progress-bar bg-dark slideInLeft" style="width:80%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection


@section('customJs')
<!-- Add custom JavaScript here if needed -->
@endsection
