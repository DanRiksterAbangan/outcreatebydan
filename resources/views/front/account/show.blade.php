@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Me</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                @include('front.account.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @include('front.message')

                <!-- About Me Section -->
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-body p-5">
                        <h2 class="h1 text-primary mb-4">About Me</h2>
                        
                        <!-- Profile Picture -->
                        <div class="text-center mb-4">
                            <img src="{{ Auth::user()?->image ? asset('profile_pic/thumb/' . Auth::user()?->image) : asset('assets/images/avatar7.png') }}" 
                                 alt="Profile Picture" 
                                 class="rounded-circle img-fluid shadow-sm border border-2 border-primary" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <!-- Name and Designation -->
                        <div class="text-center">
                            <div class="">
                                <h4 class="mb-0 fw-bold">
                                    {{ $user->name}} 
                                    @if(Auth::user()->freelancer && Auth::user()->freelancer->isVerified == 1)
                                        <img src="{{ asset('assets/images/verified.png') }}" alt="Verified Freelancer" class="ms-2" style="width: 20px; height: 20px;">
                                    @endif

                                    <!-- Show verified image beside the name if the user/client is verified -->
                                    @if(Auth::user()->client && Auth::user()->client->isVerified == 1)
                                        <img src="{{ asset('assets/images/verified.png') }}" alt="Verified Client" class="ms-2" style="width: 20px; height: 20px;">
                                    @endif 
                                </h4>
                            </div>
                            <p class="text-muted fs-6 mb-2">{{ $user->designation ?? 'No designation provided' }}</p>
                        </div>
                        

                        <!-- About Content -->
                        <div class="text-center mt-4 text-secondary">
                          {!! nl2br($user->about) !!}
                        </div>
                    </div>
                </div>

                <!-- Education Section -->
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-body p-5">
                        <h2 class="text-primary mb-4">Education</h2>
                        <div class="row g-4">
                            @foreach ([['icon' => 'ti-bookmark-alt', 'title' => 'Education', 'value' => Auth::user()?->education],
                                       ['icon' => 'ti-pencil-alt', 'title' => 'Career Start', 'value' => Auth::user()?->career_start],
                                       ['icon' => 'ti-medall-alt', 'title' => 'Experience', 'value' => Auth::user()?->experience]] as $item)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-center border-0 rounded-3 shadow-sm h-100">
                                        <div class="card-body">
                                            <i class="{{ $item['icon'] }} icon-box bg-primary text-white rounded-circle p-3 fs-4 mb-3"></i>
                                            <h5 class="h6 fw-bold">{{ $item['title'] }}</h5>
                                            <p class="text-muted small mb-0">{{ $item['value'] ?? "No {$item['title']} provided" }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Certificates & Other Info Section -->
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-body p-5">
                        <h2 class="text-primary mb-4">Other Info</h2>
                        <div class="text-secondary mb-4 text-center">
                            {!! nl2br($user->other) !!}
                        </div>

                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush rounded-3">
                                    @php
                                        // Helper function to ensure proper URL formatting
                                        function formatUrl($url) {
                                            if ($url && !preg_match('/^http(s)?:\/\//', $url)) {
                                                return 'http://' . $url;
                                            }
                                            return $url;
                                        }
                                    @endphp
                        
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fas fa-globe fa-lg text-warning"></i>
                                        <p class="mb-0">
                                            <a href="{{ formatUrl($user->portfolio) }}" target="_blank">
                                                {{ $user->portfolio }}
                                            </a>
                                        </p>
                                    </li>
                        
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                        <p class="mb-0">
                                            <a href="{{ formatUrl($user->facebook) }}" target="_blank">
                                                {{ $user->facebook }}
                                            </a>
                                        </p>
                                    </li>
                        
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                        <p class="mb-0">
                                            <a href="{{ formatUrl($user->instagram) }}" target="_blank">
                                                {{ $user->instagram }}
                                            </a>
                                        </p>
                                    </li>
                        
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                        <p class="mb-0">
                                            <a href="{{ formatUrl($user->twitter) }}" target="_blank">
                                                {{ $user->twitter }}
                                            </a>
                                        </p>
                                    </li>
                        
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-tiktok fa-lg" style="color: #55acee;"></i>
                                        <p class="mb-0">
                                            <a href="{{ formatUrl($user->tiktok) }}" target="_blank">
                                                {{ $user->tiktok }}
                                            </a>
                                        </p>
                                    </li>
                        
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-youtube fa-lg" style="color: #55acee;"></i>
                                        <p class="mb-0">
                                            <a href="{{ formatUrl($user->youtube) }}" target="_blank">
                                                {{ $user->youtube }}
                                            </a>
                                        </p>
                                    </li>
                        
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-github fa-lg text-body"></i>
                                        <p class="mb-0">
                                            <a href="{{ formatUrl($user->github) }}" target="_blank">
                                                {{ $user->github }}
                                            </a>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customCss')
<style>
    .breadcrumb a {
        text-decoration: none;
    }
    .icon-box {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }
    .custom-progress {
        height: 12px;
        background-color: #e9ecef;
    }
    .custom-bar {
        transition: width 0.4s ease;
    }
</style>
@endsection

@section('customJs')
<script>
    // Add any custom interactivity here if needed
</script>
@endsection
