@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Hires</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>

                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">All Hires</h3>
                                </div> 
                                <div style="margin-top: -10px;">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <form method="GET" action="{{ route('admin.hires.hires-list') }}">
                                        <input 
                                            value="{{ Request::get('keyword') }}" 
                                            type="text" 
                                            name="keyword" 
                                            id="keyword" 
                                            placeholder="Search a Hire Transaction" 
                                            class="form-control"
                                        >
                                    </form>
                                </div>
                                
                                <div class="ms-3">
                                    <form method="GET" action="{{ route('admin.hires.hires-list') }}">
                                        <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                                        <button type="submit" class="btn btn-secondary">Reset</button>
                                    </form>
                                </div>
                            </div>      

                            {{-- <div class="d-flex justify-content-end mb-4">
                                <div class="col-6 col-md-2">
                                    <div class="align-end">
                                        <select name="sort" id="sort" class="form-control" onchange="sortUsers()">
                                            <option value="3" {{ (Request::get('sort') == '3') ? 'selected' : ''}}>All Users</option>
                                            <option value="2" {{ (Request::get('sort') == '2') ? 'selected' : ''}}>Admins</option>
                                            <option value="1" {{ (Request::get('sort') == '1') ? 'selected' : ''}}>Freelancers</option>
                                            <option value="0" {{ (Request::get('sort') == '0') ? 'selected' : ''}}>Users/Clients</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Job Title</th>
                                            <th scope="col">Freelancer First Name</th>
                                            <th scope="col">Freelancer Middle Name</th>
                                            <th scope="col">Freelancer Last Name</th>
                                            <th scope="col">Client First Name</th>
                                            <th scope="col">Client Middle Name</th>
                                            <th scope="col">Client Last Name</th>
                                            <th scope="col">Hired Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($hires->isNotEmpty())
                                            @foreach ($hires as $hire)
                                                <tr>
                                                    <td>{{ $hire->id }}</td>
                                                    <td>
                                                        <p>{{ $hire->job->title }}</p>
                                                    </td>
                                                    <td>{{ $hire->user->firstName }}</td>
                                                    <td>{{ $hire->user->midName }}</td>
                                                    <td>{{ $hire->user->lastName }}</td>
                                                    <td>{{ $hire->employer->firstName }}</td>
                                                    <td>{{ $hire->employer->midName }}</td>
                                                    <td>{{ $hire->employer->lastName }}</td>
                                                    
                                                    <td>{{ \Carbon\Carbon::parse($hire->applied_date)->format('d M, Y') }}</td>
                                                    <td>
                                                        <div class="action-dots float-start">
                                                            <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="deleteHire({{ $hire->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center text-danger">Hire Transaction Not Found!</td>
                                            </tr>
                                        @endif
                                    </tbody>  
                                </table>
                            </div>
                            <div>
                                {{ $hires->appends(['keyword' => Request::get('keyword'), 'sort' => Request::get('sort')])->links() }}
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

        // JavaScript function to trigger page reload when sort value changes
        function sortUsers() {
                var sortValue = document.getElementById('sort').value;
                var currentUrl = window.location.href;
                var newUrl = new URL(currentUrl);
                newUrl.searchParams.set('sort', sortValue);  // Update the sort query parameter
                window.location.href = newUrl.toString();  // Reload the page with the updated sort
            }

        // Delete Hire Transaction
        function deleteHire(id) {
            if (confirm("Are you sure you want to delete this Job Application?")) {
                $.ajax({
                    url: '{{ route("admin.hires.hires-list.destroyHire") }}',
                    type: 'delete',
                    data: { id: id},
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "{{ route('admin.hires.hires-list') }}";
                    }
                });
            }
        }
    </script>
@endsection