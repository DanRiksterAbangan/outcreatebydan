@extends('front.layouts.app')

@section('main')
<section class="section-3 py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-10">
                <h2 class="text-blue-600">Find Jobs</h2> <!-- Tailwind class for primary color -->
            </div>
            <div class="col-6 col-md-2">
                <div class="w-full flex justify-end"> <!-- Flexbox for alignment -->
                    <select name="sort" id="sort" class="w-full sm:w-auto border border-gray-300 rounded-lg p-2 shadow-sm focus:ring focus:ring-blue-200" onchange="redirectToSort()">
                        <option value="1" {{ (Request::get('sort') == '1' ? 'selected' : '') }}>Latest</option>
                        <option value="0" {{ (Request::get('sort') == '0' ? 'selected' : '') }}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>
        

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                    <div class="card border-0 shadow-lg p-4 rounded-3 bg-white">
                        <!-- Keywords Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Job Title</h2>
                            <input type="text" name="keyword" id="keyword" placeholder="Enter job title or keywords" class="form-control border-0 shadow-sm p-3 rounded-2" value="{{ Request::get('keyword') }}">
                        </div>

                        <!-- Location Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Location</h2>
                            <input type="text" name="location" id="location" placeholder="City, State, or Zip Code" class="form-control border-0 shadow-sm p-3 rounded-2" value="{{ Request::get('location') }}">
                        </div>

                        <!-- Category Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-12">Category</h2>
                            <select name="category" id="category" class="w-full h-16 border border-gray-300 shadow-sm p-3 rounded-lg focus:ring focus:ring-blue-200">
                                <option value="">Select a Category</option>
                                @if ($categories)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ Request::get('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        

                        <!-- Job Type Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Job Type</h2>
                            <div class="d-flex flex-column">
                                @if ($jobTypes && $jobTypes->isNotEmpty())
                                    @foreach ($jobTypes as $jobType)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input shadow-sm" type="checkbox" id="jobTypeCheckbox{{ $jobType->id }}" value="{{ $jobType->id }}" name="jobTypes[]"
                                                {{ in_array($jobType->id, (array) Request::get('jobTypes', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jobTypeCheckbox{{ $jobType->id }}">{{ $jobType->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        

                        <!-- Experience Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Experience</h2>
                            <select name="experience" id="experience" class="form-control border-0 shadow-sm rounded-2" style="height: 50px;">
                                <option value="">Select Experience</option>
                                <option value="1">1 Year</option>
                                <option value="2">2 Years</option>
                                <option value="3">3 Years</option>
                                <option value="4">4 Years</option>
                                <option value="5">5+ Years</option>
                            </select>
                            
                        </div>

                        <!-- Search Button -->
                        <div class="d-grid">
                            <button class="btn btn-primary shadow-sm py-3" type="submit">
                                <i class="fas fa-search me-2"></i> Search Jobs
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="job_listing_area">
                    <div class="job_lists">
                        <div class="row g-4">
                            @if ($jobs->isNotEmpty())
                                @foreach ($jobs as $job)
                                    <div class="col-12 mb-4"> <!-- Full width for each job item -->
                                        <div class="job-item p-4 border rounded shadow">
                                            <div class="row g-4">
                                                <!-- Job Info (Logo, Title, Location, Type, Salary) -->
                                                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                                    <img class="flex-shrink-0 img-fluid border rounded" src="{{ $job->company_logo ?? 'default-logo.jpg' }}" alt="{{ $job->company_name }}" style="width: 80px; height: 80px;">
                                                    <div class="text-start ps-4">
                                                        <h5 class="mb-3">{{ $job->title }}</h5>
                                                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $job->location }}</span>
                                                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>{{ $job->jobType->name }}</span>
                                                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>{{ $job->salary ?? 'Negotiable' }}</span>
                                                    </div>
                                                </div>
                    
                                                <!-- Apply Button and Deadline -->
                                                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                    <div class="d-flex mb-3">
                                                        <a class="btn btn-light btn-square me-3" href="{{ route('jobDetail', $job->id) }}"><i class="far fa-heart text-primary"></i></a>
                                                        <a class="btn btn-primary" href="{{ route('jobDetail', $job->id) }}">Apply Now</a>
                                                    </div>
                                                    <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d M, Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                    
                                <!-- Pagination and Job Count -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <span class="text-muted font-light">Showing {{ $jobs->firstItem() }} to {{ $jobs->lastItem() }} of {{ $jobs->total() }} jobs</span>
                                    </div>
                                    <div>
                                        {{ $jobs->links('pagination::bootstrap-5') }} <!-- Bootstrap pagination -->
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 text-center text-danger">No jobs found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
             
            
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    // Redirect to sort on change
    function redirectToSort() {
        const sortValue = document.getElementById('sort').value;
        const currentUrl = window.location.href.split('?')[0]; // Get current URL without query params
        let url = `${currentUrl}?sort=${sortValue}`; // Base URL for the jobs route
        
        // Append existing form parameters
        url += generateQueryParams();
        window.location.href = url; // Navigate to the constructed URL
    }

    // Generate query parameters from the form
    function generateQueryParams() {
        const params = [];
        const keyword = document.getElementById("keyword").value;
        const location = document.getElementById("location").value;
        const category = document.getElementById("category").value;
        const experience = document.getElementById("experience").value;

        // Add parameters if they have values
        if (keyword) params.push(`keyword=${encodeURIComponent(keyword)}`);
        if (location) params.push(`location=${encodeURIComponent(location)}`);
        if (category) params.push(`category=${encodeURIComponent(category)}`);
        if (experience) params.push(`experience=${encodeURIComponent(experience)}`);

        // Handle the job types checkboxes
        const checkedJobTypes = Array.from(document.querySelectorAll("input[name='jobTypes[]']:checked"))
            .map(input => input.value);
        if (checkedJobTypes.length > 0) {
            params.push(`jobTypes[]=${encodeURIComponent(checkedJobTypes.join('&jobTypes[]='))}`);
        }

        return params.length > 0 ? '&' + params.join('&') : ''; // Join params and return
    }

    // Submit the form on search button click
    document.getElementById("searchForm").addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent the default form submission
        const url = '{{ route("jobs") }}?' + generateQueryParams();
        window.location.href = url; // Redirect to the constructed URL
    });
</script>
@endsection
