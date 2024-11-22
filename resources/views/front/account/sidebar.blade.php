<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
        @if(Auth::check())
            @if(!empty(Auth::user()->image))
                <img src="{{ asset('profile_pic/thumb/'.Auth::user()->image) }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            @else
                <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            @endif

            <div class="d-flex justify-content-center align-items-center mt-3 pb-0">
                <h5 class="mb-0">
                    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}

                    <!-- Show verified image beside the name if the freelancer is verified -->
                    @if(Auth::user()->freelancer && Auth::user()->freelancer->isVerified == 1)
                        <img src="{{ asset('assets/images/verified.png') }}" alt="Verified Freelancer" class="ms-2" style="width: 20px; height: 20px;">
                    @endif

                    <!-- Show verified image beside the name if the user/client is verified -->
                    @if(Auth::user()->client && Auth::user()->client->isVerified == 1)
                        <img src="{{ asset('assets/images/verified.png') }}" alt="Verified Client" class="ms-2" style="width: 20px; height: 20px;">
                    @endif       
                </h5>
            </div>

            <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation ?? 'No designation provided' }}</p>
            <div class="d-flex justify-content-center mb-2">
                <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
            </div>
        @else
            <p class="text-center text-muted">You need to log in to view this section.</p>
        @endif
    </div>
</div>


@if(Auth::check())
    <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between p-3">
                    <a href="{{ route('account.show', ['id' => Auth::user()->id]) }}">Me</a>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3">
                    <a href="{{ route('account.profile') }}">Profile Settings</a>
                </li>
                <li class="list-group-item d-flex justify-content-between p-3">
                    <a href="{{ route('account.accountPassword') }}">Change Password</a>
                </li>

                {{-- Client and Admin Sidebar --}}
                @if (Auth::user()->role == 'user' || Auth::user()->role == 'admin')
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <a href="{{ route('account.client-verify') }}">Verify Now</a>
                    </li>

                    {{-- Shows All Job Features if Client is Verified --}}
                    @if(Auth::user()->client && Auth::user()->client->isVerified == 1)
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="{{ route('account.createJob') }}">Post a Job</a>
                        </li> 

                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="{{ route('account.myJobs') }}">My Jobs</a>
                        </li>
    
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="{{ route('account.hires') }}">Hired Freelancers</a>
                        </li>
                    @else
                        <p class="list-group-item d-flex justify-content-between align-items-center p-3">Please Verify first to acquire Job Features.</p>
                    @endif       
                @endif           

                {{-- Freelancer and Admin Sidebar --}}
                @if (Auth::user()->role == 'freelancer' || Auth::user()->role == 'admin')
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <a href="{{ route('freelancer.verify-now') }}">Verify Now</a>
                    </li>

                    <!-- Show verified image beside the name if the freelancer is verified -->
                    @if(Auth::user()->freelancer && Auth::user()->freelancer->isVerified == 1)
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="{{ route('account.myJobApplications') }}">Jobs Applied</a>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="{{ route('account.savedJobs') }}">Saved Jobs</a>
                        </li>  
                    @else
                    <p class="list-group-item d-flex justify-content-between align-items-center p-3">Please Verify first to acquire Job Features.</p>
                    @endif

                @endif
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('account.logout') }}">Logout</a>
                </li>                                                        
            </ul>
        </div>
    </div>
@endif
