@extends('front.layouts.app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>

            <!-- Success and Error Alerts -->
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Section Introduction -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold text-primary">Welcome Back!</h2>                </div>
            </div>

            <!-- Login Form -->
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3 mb-4 text-center">Login</h1>
                        <form action="{{ route('account.authenticate') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="johndoe@email.com" required>
                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="******" required>
                                @error('password')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary mt-2 px-4 py-2">Login</button>
                                <a href="{{ route('account.forgotPassword') }}" class="mt-3 text-decoration-none text-primary">Forgot Password?</a>
                            </div>
                        </form>

                        <!-- Optional Social Login Section -->
                        <div class="text-center mt-4">
                            <p class="text-muted">Or login with</p>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-outline-primary me-2">
                                    <i class="fab fa-google me-2"></i> Google
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fab fa-facebook me-2"></i> Facebook
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Help Section -->
                    <div class="mt-4 text-center">
                        <p>Do not have an account? <a href="{{ route('account.registration') }}" class="text-decoration-none text-primary">Register</a></p>                    </div>
                </div>
            </div>

            <!-- Footer Links (Privacy Policy, Terms) -->
            <div class="mt-5 text-center">
                <p><a href="#" class="text-muted text-decoration-none">Privacy Policy</a> | <a href="##" class="text-muted text-decoration-none">Terms and Conditions</a></p>
            </div>

            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection
