@extends('front.layouts.app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Client Register</h1>
                        <form action="" name="registrationForm" id="registrationForm">
                            @csrf
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            
                            <div class="mb-3">
                                <label for="" class="mb-2">First Name*</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="John">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Middle Name* (Put N/A if not applicable.)</label>
                                <input type="text" name="midName" id="midName" class="form-control" placeholder="Smith">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Last Name*</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Doe">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@email.com">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="********">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="********">
                                <p></p>
                            </div> 
                            <button class="btn btn-primary mt-2">Register</button>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a  href="{{ route('account.login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function handleErrors(errors, fields) {
            fields.forEach(field => {
                if (errors[field]) {
                    $(`#${field}`).addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors[field]);
                } else {
                    $(`#${field}`).removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('');
                }
            });
        }

        $("#registrationForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("account.processRegistration") }}',
                type: 'post',
                data: $("#registrationForm").serializeArray(),
                dataType: 'json',
                success: function(response) {
                    const fields = ['firstName', 'midName', 'lastName', 'email', 'password', 'confirmPassword'];
                    if (response.status == false) {
                        handleErrors(response.errors, fields);
                    } else {
                        fields.forEach(field => $(`#${field}`).removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html(''));
                        window.location.href = response.redirect;
                    }
                }
            });
        });
    </script>
@endsection
