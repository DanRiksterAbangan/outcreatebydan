@extends('front.layouts.app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Client Register</h1>
                        <form action="{{ route('account.processRegistration') }}" method="POST" name="registrationForm" id="registrationForm">
                            @csrf
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            
                            <div class="mb-3">
                                <label for="name" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="John Doe">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@email.com">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="********">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="confirmPassword" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="********">
                                <p></p>
                            </div> 
                            <button type="submit" class="btn btn-primary mt-2">Register</button>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        function handleErrors(errors, fields) {
            fields.forEach(field => {
                if (errors[field]) {
                    $(`#${field}`).addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors[field][0]);
                } else {
                    $(`#${field}`).removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('');
                }
            });
        }

        jQuery("#registrationForm").on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            jQuery.ajax({
                url: jQuery(this).attr('action'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: jQuery(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === true) {
                        // Redirect to login page
                        window.location.href = response.redirect;
                    } else {
                        var errors = response.errors;
                        handleErrors(errors, ["name", "email", "password", "confirmPassword"]);
                    }
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                    alert("You have Registered Successfully! You may now Login to your account!");
                }
            });
        });
    </script>
@endsection
