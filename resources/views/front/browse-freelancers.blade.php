@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">


                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow mb-4"></div>
                </div>
<div class="container py-5">
    <h2 class="text-center mb-4">Browse Freelancers</h2>

    <div class="row">
        <!-- Freelancer Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Freelancer Image">
                <div class="card-body">
                    <h5 class="card-title">John Doe</h5>
                    <p class="card-text">
                        <strong>Skills:</strong> Web Development, PHP, Laravel
                    </p>
                    <p class="card-text">
                        <strong>Status:</strong> Available for Hire
                    </p>
                    <a href="#" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>

        <!-- Freelancer Card 2 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Freelancer Image">
                <div class="card-body">
                    <h5 class="card-title">Jane Smith</h5>
                    <p class="card-text">
                        <strong>Skills:</strong> Graphic Design, UI/UX, Photoshop
                    </p>
                    <p class="card-text">
                        <strong>Status:</strong> Available for Hire
                    </p>
                    <a href="#" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>

        <!-- Freelancer Card 3 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Freelancer Image">
                <div class="card-body">
                    <h5 class="card-title">Mark Johnson</h5>
                    <p class="card-text">
                        <strong>Skills:</strong> Data Analysis, Python, SQL
                    </p>
                    <p class="card-text">
                        <strong>Status:</strong> Not Available
                    </p>
                    <a href="#" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
    </section>
@endsection

@section('customJs')
@endsection