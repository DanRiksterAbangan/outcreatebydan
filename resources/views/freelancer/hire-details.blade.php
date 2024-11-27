@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Hired Job Transaction</li>
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
                    <form action="{{ route('freelancer.updateLink', ['id' => $hire->id]) }}" method="POST" id="editHireForm" name="editHireForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card border-0 shadow mb-4">
                            <div class="container"> 
                                <div class="row m-0"> 
                                    <div class="col"> 
                                        <div class="row"> 
                                            <div class="col-12 px-0 mb-4"> 
                                                <div class="d-flex justify-content-between" style="gap: 20px;">
                                                    <div class="box-left" style="flex: 1;"> 
                                                        <div class="d-flex pb-2"> 
                                                            <p class="fw-bold h7">
                                                                Job Posting ID: 
                                                            </p>
                                                        </div> 
                                                        <h2 class="bold">
                                                            {{ $transaction->id }}
                                                        </h2>
                                                    </div> 
                    
                                                    <div class="box-right" style="flex: 1;"> 
                                                        <div class="d-flex pb-2"> 
                                                            <p class="fw-bold h7">
                                                                Transaction ID:  
                                                            </p>
                                                        </div>
                                                        <h2 class="bold">
                                                            {{ $transaction->job_id }}
                                                        </h2>
                                                    </div> 

                                                    <div class="box-right" style="flex: 1;"> 
                                                        <div class="d-flex pb-2"> 
                                                            <p class="fw-bold h7">
                                                                Employer ID:  
                                                            </p>
                                                        </div>
                                                        <h2 class="bold">
                                                            {{ $transaction->employer->id }}
                                                        </h2>
                                                    </div> 
                                                </div>                                           
                                            </div>               
                    
                                            <!-- Add Hidden Input for hire_status -->
                                            <input type="hidden" name="hire_status" value="{{ old('hire_status', $hire->hire_status) }}">

                                            <div class="row justify-content-center">
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-4">
                                                        <label for="firstName" class="mb-2 d-block text-center" style="font-weight: 600; font-size: 1.1rem;">Employer Name</label>

                                                        <input value="{{ $transaction ? $transaction->employer->name : '' }}" type="text" id="firstName" name="firstName" class="form-control text-center" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            
                    
                                            <div class="col-12 d-flex justify-content-between mb-4">
                                                <!-- Salary Section -->
                                                <div class="w-50 pe-2">
                                                    <div class="p-3 border rounded shadow-sm h-100">
                                                        <p class="text-muted fw-bold h6 mb-0 pb-3">EXPECTED SALARY</p>
                                                        <p class="h1 fw-bold d-flex align-items-center">
                                                            <i class="fa-solid fa-peso-sign me-2"></i>
                                                            @if (!empty($job->salary))
                                                                {{ $job->salary }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                                <!-- Project Progress Section -->
                                                <div class="w-50 ps-2">
                                                    <div class="p-3 border rounded shadow-sm h-100">
                                                        <p class="fw-bold h7 mb-2">
                                                            <span>Project Progress</span> Link
                                                        </p>
                                                        <input type="text" name="progress_link" placeholder="Freelancer Project Progress Link" id="progress_link" class="text-center form-control text-dark" value="{{ old('progress_link', $hire->progress_link) }}">
                                                    </div>
                                                </div>
                                            </div>     
                    
                                            <div class="col-12 px-0 mb-4">
                                                <div class="row">
                                                    <!-- Interview and Assessment Link (Left) -->
                                                    <div class="col-md-6 pe-3">
                                                        <div class="p-3 border rounded shadow-sm h-100">
                                                            <p class="fw-bold h7 mb-2">
                                                                <span>Interview and Assessment</span> Link
                                                            </p>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" name="" value="{{ $hire->assessment_link }}" id="myInput" class="text-center form-control me-2" readonly>
                                                                <button class="btn btn-primary" id="clipboard" onclick="myFunction()">Copy Link</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <!-- Company Information (Right) -->
                                                    <div class="col-md-6 ps-3">
                                                        <div class="p-3 border rounded shadow-sm h-100">
                                                            <p class="fw-bold h6 mb-3">Company</p>
                                                            <p class="h1 fw-bold">
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
                                            </div>                                         
                    
                                            <div class="col-12 px-0 rounded" style="background: wheat"> 
                                                <div class="box-right"> 
                                                    <div class="d-flex mb-2"> 
                                                        <p class="fw-bold">Hire Status</p> 
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="progress-track">
                                                            <ul id="progressbar">
                                                                <li class="step0 {{ $hire->hire_status >= 0 ? 'active' : '' }}" id="step1">Initial Interview</li>
                                                                <li class="step0 {{ $hire->hire_status >= 1 ? 'active' : '' }} text-center" id="step2">Assessment</li>
                                                                <li class="step0 {{ $hire->hire_status >= 2 ? 'active' : '' }} text-right text-end" id="step3">Final Interview</li>
                                                                <li class="step0 {{ $hire->hire_status == 3 ? 'active' : '' }} text-right text-end" id="step4">Hired</li>
                                                            </ul>
                                                        </div>
                                                    </div> 
                                                </div> 
                                            </div>  
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end pt-3">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('account.myJobApplications') }}" class="btn btn-outline-danger">Cancel</a>
                            </div>
                        </div>
                    </form>                                   
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("myInput");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("Copied the text: " + copyText.value);
        }
    </script>
@endsection