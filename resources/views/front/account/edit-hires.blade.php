@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.jobs.jobs-list') }}">Hires</a></li>
                            <li class="breadcrumb-item active">Hire Transaction Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>

                <div class="col-lg-9">
                    @include('front.message')
                    <form action="#" method="POST" id="editHireForm" name="editHireForm" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Transaction Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="id" class="mb-2">Transaction ID</label>
                                        <input value="{{ $freelancer ? $freelancer->id : '' }}" type="text" id="id" name="id" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6  mb-4">
                                        <label for="freelancer_id" class="mb-2">Freelancer ID</label>
                                        <input value="{{ $freelancer ? $freelancer->id : '' }}" type="text" id="id" name="id" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-4">
                                        <label for="firstName" class="mb-2">Freelancer First Name</label>
                                        <input value="{{ $freelancer ? $freelancer->firstName : '' }}" type="text" id="id" name="id" class="form-control" readonly>
                                    </div>
        
                                    <div class="mb-4 col-md-4">
                                        <label for="midName" class="mb-2">Freelancer Middle Name</label>
                                        <input value="{{ $freelancer ? $freelancer->midName : '' }}" type="text" id="id" name="id" class="form-control" readonly>
                                    </div>

                                    <div class="mb-4 col-md-4">
                                        <label for="lastName" class="mb-2">Freelancer Last Name</label>
                                        <input value="{{ $freelancer ? $freelancer->lastName : '' }}" type="text" id="id" name="id" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-12 mb-4"> 
                                    <div class="row box-right"> 
                                        <div class="col-md-8 ps-0 "> 
                                            <p class="ps-3 textmuted fw-bold h6 mb-0 pb-3">SALARY</p> 
                                            <p class="h1 fw-bold d-flex">
                                                <i class="fa-solid fa-peso-sign"></i> 
                                                @if (!empty($job->salary))
                                                    {{ $job->salary }}
                                                @endif
                                            </p>
                                        </div> 
                                    </div>
                                </div>

                                <div class="col-12 mb-4 d-flex">
                                    <!-- Employer box (left side) -->
                                    <div class="box-left w-50 pe-3">
                                        <div class="col-md-12 ps-0"> 
                                            <p class="ps-3 textmuted fw-bold h6 mb-0 pb-3">Employer</p> 
                                            <p class="h1 fw-bold d-flex">
                                                @if (!empty($client->firstName))
                                                    {{ $client->firstName }}
                                                @endif
                                                @if (!empty($client->midName))
                                                    {{ $client->midName }}
                                                @endif
                                                @if (!empty($client->lastName))
                                                    {{ $client->lastName }}
                                                @endif
                                                @if (!empty($client->location))
                                                    {{ $client->location }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                
                                    <!-- Company box (right side) -->
                                    <div class="box-right w-50 ps-3">
                                        <div class="col-md-12 ps-0"> 
                                            <p class="ps-3 textmuted fw-bold h6 mb-0 pb-3">Company</p> 
                                            <p class="h1 fw-bold d-flex">
                                                @if (!empty($job->company_name))
                                                    {{ $job->company_name }}
                                                @endif
                                                @if (!empty($job->company_location))
                                                    {{ $job->company_location }}
                                                @endif
                                                @if (!empty($job->company_website))
                                                    {{ $job->company_website }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>                                                                                                                      

                                <div class="col-12 px-0 mb-4 d-flex justify-content-between">
                                    <!-- Interview and Assessment Link -->
                                    <div class="box-right w-48 pe-2">
                                        <div class="d-flex pb-2"> 
                                            <p class="fw-bold h7">
                                                <span class="">Interview and Assessment</span> Link
                                            </p> 
                                        </div>
                                        <div id="col">
                                            <input type="text" name="" placeholder="Enter Interview or Assessment Link Here" id="myInput" class="bg btn btn-primary h8 text-left text-dark">
                                        </div>                                 
                                    </div>
                                
                                    <!-- Job Status and Radio Buttons -->
                                    <div class="mb-4 col-md-6 w-48 ps-2">
                                        <label for="" class="mb-2 fw-bold h7">Job Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="3" id="isActive-active" name="isActive">
                                            <label class="form-check-label" for="isActive-active">
                                                Hired
                                            </label>
                                        </div>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="2" id="isActive-final-interview" name="isActive">
                                            <label class="form-check-label" for="isActive-final-interview">
                                                Final Interview
                                            </label>
                                        </div>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="1" id="isActive-assessment" name="isActive">
                                            <label class="form-check-label" for="isActive-assessment">
                                                Assessment
                                            </label>
                                        </div>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="0" id="isActive-initial-interview" name="isActive">
                                            <label class="form-check-label" for="isActive-initial-interview">
                                                Initial Interview
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Centered Button to Open the Modal -->
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#myModal">Pay Now</button>
                                </div>

                                <!-- Modal -->
                                <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content p-3">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel">Payment Form</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="/process-payment" class="p-3">
                                                <div class="mb-4">
                                                    <!-- Payment ID -->
                                                    <label for="reference_id" class="form-label fw-bold h7">Payment ID</label>
                                                    <input type="text" name="reference_id" placeholder="Reference ID" id="reference_id" class="form-control text-dark">
                                                </div>
                                                <div class="mb-4">
                                                    <!-- Bank Name -->
                                                    <label for="bank_name" class="form-label fw-bold h7">If Bank Transfer - Bank Name</label>
                                                    <input type="text" name="bank_name" placeholder="Bank Name" id="bank_name" class="form-control text-dark">
                                                </div>
                                                <div class="mb-4">
                                                    <!-- Payment Method -->
                                                    <label for="payment_method" class="form-label fw-bold h7">Payment Method</label>
                                                    <select name="payment_method" id="payment_method" class="form-select text-dark">
                                                        <option value="3">Gcash</option>
                                                        <option value="2">Maya</option>
                                                        <option value="1">Paypal</option>
                                                        <option value="0">Bank Transfer</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <!-- Bank Name -->
                                                    <label for="proof" class="form-label fw-bold h7">Transaction Image</label>
                                                    <input type="file" name="proof" placeholder="Transction Image" id="proof" class="form-control text-dark">
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end pt-3">
                                    <button type="submit" class="btn btn-primary me-2">Update Request</button>
                                    <a href="{{ route('admin.freelancer-verifications.list') }}" class="btn btn-outline-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- <script>
        document.getElementById('openModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('exampleModal1'));
            modal.show();
        });

        document.getElementById('openSelfieModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('selfieModal'));
            modal.show();
        });

        document.getElementById('openDiplomaModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('diplomaModal'));
            modal.show();
        });

        document.getElementById('openCertificateModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('certificateModal'));
            modal.show();
        });
    </script> --}}
@endsection
