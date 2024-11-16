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
                                    <label for="" class="mb-2">First Name*</label>
                                    <input type="text" name="firstName" id="firstName" placeholder="John" class="form-control" value="{{ $user->firstName }}">
                                    <p></p>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Middle name*</label>
                                    <input type="text" name="midName" id="midName" placeholder="Smith" class="form-control" value="{{  $user->midName }}">
                                    <p></p>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Last Name*</label>
                                    <input type="text" name="lastName" id="lastName" placeholder="Doe" class="form-control" value="{{ $user->lastName }}">
                                    <p></p>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow mb-4">
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">Credentials</h3>
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

                        <div class="card border-0 shadow mb-4">
                            <div class="card-body p-4">
                                <h3 class="fs-4 mb-1">Change Password</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Old Password*</label>
                                    <input type="password" placeholder="Old Password" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">New Password*</label>
                                    <input type="password" placeholder="New Password" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Confirm Password*</label>
                                    <input type="password" placeholder="Confirm New Password" class="form-control">
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

                        window.location.href="{{ route('account.profile') }}";

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