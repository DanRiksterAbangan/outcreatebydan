@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <form action="" method="post" id="userForm" name="userForm" class="col-lg-9">
                    @include('front.message')
                    <div>
                        <div class="card border-0 shadow mb-4">
                            <div class="card-body p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                                <div class="mb-4">
                                    <label for="name" class="form-label mb-2">Full Name<span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="name" 
                                        placeholder="Enter your full name" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name', $user->name) }}"
                                        required 
                                    >
                                    
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for="about" class="mb-2 mt-4">About Me</label>
                                    <textarea class="textarea" name="about" id="about" cols="5" rows="5" placeholder="About Me" value="{{ $user->about }}"></textarea>
                                    <p></p>
                                </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="card border-0 shadow mb-4">
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">Contacts</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" name="email" id="email" placeholder="johndoe@email.com" value="{{ $user->email }}" class="form-control">
                                    <p></p>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation</label>
                                    <input type="text" name="designation" id="designation" placeholder="Designation" value="{{ $user->designation }}" class="form-control">
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile</label>
                                    <input type="number" name="mobile" id="mobile" placeholder="Mobile" value="{{ $user->mobile }}" class="form-control">
                                </div>   
                            </div>
                        </div>

                        {{-- About --}}
                        <div class="card border-0 shadow mb-4">
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">More Info</h3>
                                <div class="mb-4">

                                <div class="mb-4">
                                    <label for="education" class="mb-2">Education</label>
                                    <input type="text" name="education" id="education" placeholder="Education" value="{{ $user->education }}" class="form-control">
                                </div>

                                <div class="mb-4">
                                    <label for="career_start" class="mb-2">Career Start</label>
                                    <input type="text" name="career_start" id="career_start" placeholder="Career Start" value="{{ $user->career_start }}" class="form-control">
                                </div>   

                                <div class="mb-4">
                                    <label for="experience" class="mb-2">Experience</label>
                                    <input type="text" name="experience" id="experience" placeholder="Experience" value="{{ $user->experience }}" class="form-control">
                                </div>   

                                <div class="mb-4">
                                    <label for="other" class="mb-2">Other Info</label>
                                    <textarea class="textarea" name="other" id="other" cols="5" rows="5" placeholder="Other Info" value="{{ $user->other }}"></textarea>
                                    <p></p>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow mb-4">
                            <div class="card-body p-4">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        $("#userForm").submit(function(e){
            e.preventDefault();

            $.ajax({
                url:'{{ route("account.updateProfile") }}',
                type: 'put',
                dataType: 'json',
                data: $("#userForm").serializeArray(),
                success: function(response) {
                    
                    if(response.status == true) {

                        $("#firstName").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#midName").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#lastName").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#email").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        window.location.href="{{ route('account.show', ['id' => Auth::user()->id]) }}";

                    } else {
                        var errors = response.errors;

                        if (errors.firstName) {
                                $("#firstName").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.firstName)
                            } else {
                                $("#firstName").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                            }

                            if (errors.midName) {
                                $("#midName").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.midName)
                            } else {
                                $("#midName").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                            }

                            if (errors.lastName) {
                                $("#lastName").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.lastName)
                            } else {
                                $("#lastName").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                            }

                            if (errors.email) {
                                $("#email").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.email)
                            } else {
                                $("#email").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                            }
                    }

                }
            });
        });
    </script>
@endsection