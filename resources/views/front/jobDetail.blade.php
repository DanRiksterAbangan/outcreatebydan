@extends('front.layouts.app')

@section('main')
    <section class="section-4 bg-2">    
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div> 
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    @include('front.message')
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    
                                    <div class="jobs_conetent">
                                        <a href="#">
                                            <h4>{{ $job->title }}</h4>
                                        </a>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p> <i class="fa fa-map-marker"></i> {{ $job->location }}</p>
                                            </div>
                                            <div class="location">
                                                <p> <i class="fa fa-clock-o"></i> {{ $job->jobType->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="apply_now {{ ($count == 1) ? 'saved-job' : '' }}">
                                        <a class="heart_mark" href="javascript:void(0);" onclick="saveTheJob({{ $job->id }})"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <div class="single_wrap">
                                <h4>Job description</h4>
                                {!! nl2br($job->description) !!}
                            </div>
                            
                        @if (!empty($job->responsibility))
                            <div class="single_wrap">
                                <h4>Responsibility</h4>
                                    {!! nl2br($job->responsibility) !!}
                            </div>
                        @endif

                        @if (!empty($job->qualifications))
                            <div class="single_wrap">
                                <h4>Qualifications</h4>
                                    {!! nl2br($job->qualifications) !!}
                            </div>
                        @endif

                        
                        @if (!empty($job->benefits))
                            <div class="single_wrap">
                                <h4>Benefits</h4>
                                    {!! nl2br($job->benefits) !!}
                            </div>
                        @endif

                            <div class="border-bottom"></div>
                            <div class="pt-3 text-end">
                                @if (Auth::check())
                                    <a href="#" onclick="saveTheJob({{ $job->id }})" class="btn btn-secondary">Save</a>   
                                @else
                                    <a href="javascript:void(0);" class="btn btn-secondary disabled">Login to Save</a>
                                @endif

                                @if (Auth::check())
                                    <a href="#" onclick="applyJob({{ $job->id }})" class="btn btn-primary">Apply</a>
                                @else
                                    <a href="javascript:void(0);" class="btn btn-primary disabled">Login to Apply</a>
                                @endif

                            </div>
                        </div>
                    </div>

                    @if (Auth::user())
                        @if (Auth::user()->id == $job->user_id)
                            <div class="card shadow border-0 mt-4">
                                <div class="job_details_header">
                                    <div class="single_jobs white-bg d-flex justify-content-between">
                                        <div class="jobs_left d-flex align-items-center">
                                            
                                            <div class="jobs_conetent">
                                                <h4>Applicants</h4>
                                                
                                            </div>
                                        </div>
                                        <div class="jobs_right">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="descript_wrap white-bg">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Applied Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @if ($applications->isNotEmpty())
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td>{{ $application->user->firstName }}</td>
                                                    <td>{{ $application->user->lastName }}</td>
                                                    <td>{{ $application->user->email }}</td>
                                                    <td>{{ $application->user->mobile }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('account.show', ['id' => $application->user->id]) }}" class="btn btn-secondary">Visit</a>
                                                        <a href="#" onclick="hireFreelancer({{ $application->id }}, {{ $job->id }}, {{ $application->user->id }})" class="btn btn-primary">Hire</a>
                                                    </td>                                           
                                                </tr>
                                            @endforeach
                                        @else
                                                <tr>
                                                    <td colspan="3">No Applicants Yet.</td>
                                                </tr>
                                        @endif
                                    </table>
                                    
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Job Summary</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on: <span>{{ Carbon\Carbon::parse($job->created_at)->format('d, M Y') }}</span></li>
                                    <li>Vacancy: <span>{{ $job->vacancy }}</span></li>

                                    @if (!empty($job->salary))
                                        <li>Salary: <span>{{ $job->salary }}</span></li>
                                    @endif

                                    <li>Location: <span>{{ $job->location }}</span></li>
                                    <li>Job Nature: <span>{{ $job->jobType->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $job->company_name }}</span></li>
                                    @if (!empty($job->company_location))
                                        <li>Location: <span>{{ $job->company_location }}</span></li>
                                    @endif

                                    @if (!empty($job->company_website))
                                    <li>Website: <span><a href="">{{ $job->company_website }}</a></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
function hireFreelancer(applicationId, jobId, freelancerId) {
        // Debugging: log the values to ensure they are correct
        console.log("Application ID:", applicationId);
        console.log("Job ID:", jobId);
        console.log("Freelancer ID:", freelancerId);

        if (confirm("Are you sure you want to hire this Freelancer?")) {
            $.ajax({
                url: '{{ route("hireFreelancer") }}',
                type: 'POST',
                data: {
                    job_id: jobId,
                    freelancer_id: freelancerId,
                    application_id: applicationId,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                },
                dataType: 'json',
                success: function(response) {
                    // Check if the response is valid before taking action
                    if(response.status) {
                        alert(response.message); 
                        window.location.reload(); // Reload the page on success
                    } else {
                        alert(response.message); // Alert the error message
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error:", xhr.responseText); // Log error for debugging
                    alert("An error occurred while hiring the freelancer.");
                }
            });
        }
    }

        function applyJob(id) {
            if (confirm("Are you sure you want to apply for this Job?")) {
                $.ajax({
                    url: '{{ route("applyJob") }}',
                    type: 'post',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF Token
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "{{ url()->current() }}";
                    }
                });
            }
        }

        function saveTheJob(id) {
            $.ajax({
                url: '{{ route("saveTheJob") }}',
                type: 'post',
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF Token
                },
                dataType: 'json',
                success: function(response) {
                    window.location.href = "{{ url()->current() }}";
                }
            });
        }

    </script>
@endsection