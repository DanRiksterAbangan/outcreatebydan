@extends('front.layouts.app')

@section('main')
       <!-- Contact Start -->
       <div class="container-xxl py-5">
        <div class="container">
            <div class="container-xxl py-5 bg-dark page-header mb-5" style="background-image:url('{{ asset ('assets/images/banner-1.jpg') }}'); background-position: center; background-repeat: no-repeat;">
                <h1 class="text-center text-white mb-5 wow fadeInUp" data-wow-delay="0.1s">Contact For Any Query</h1>
            </div>
            <div class="row g-4">
                <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="d-flex align-items-center bg-light rounded p-4">
                                <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="fa fa-map-marker-alt text-primary"></i>
                                </div>
                                <span>City of Naga, Cebu, Philippines</span>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeIn" data-wow-delay="0.3s">
                            <div class="d-flex align-items-center bg-light rounded p-4">
                                <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="fa fa-envelope-open text-primary"></i>
                                </div>
                                <span>techhive@freelancing.com</span>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeIn" data-wow-delay="0.5s">
                            <div class="d-flex align-items-center bg-light rounded p-4">
                                <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="fa fa-phone-alt text-primary"></i>
                                </div>
                                <span>+639 920 628 141</span>
                            </div>
                        </div>
                    </div>
                </div>
                @include('front.message')
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <iframe class="position-relative rounded w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3926.710194522518!2d123.75248552964338!3d10.204173299703045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a97853a1ef0a53%3A0x33c142d07a44658a!2sProfessional%20Academy%20of%20the%20Philippines!5e0!3m2!1sen!2sph!4v1731950104790!5m2!1sen!2sph"
                        frameborder="0" style="min-height: 400px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
                <div class="col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <h1>Tell us what's on your mind!</h1>
                        <form action="{{ route('processContact') }}" method="post" id="createContactForm" name="createContactForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                                        <label for="subject">Subject</label>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" name="message" id="message" style="height: 150px"></textarea>
                                        <label for="message">Message</label>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

@section('customJs')
    <script>
        $("#createContactForm").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: '{{ route("processContact") }}',
                type: 'post',
                data: $("#createContactForm").serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if(response.status == false) {
                        var errors = response.errors;
                            if (errors.name) {
                                $("#name").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.name)
                            } else {
                                $("#name").removeClass('is-invalid')
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

                            if (errors.subject) {
                                $("#subject").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.subject)
                            } else {
                                $("#subject").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                            }

                            if (errors.message) {
                                $("#message").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.message)
                            } else {
                                $("#message").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                            }
                    } else {
                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');

                        $("#email").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');

                        $("#subject").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');

                        $("#message").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');

                        window.location.href='{{ route("contact") }}';
                    }
                }
            });
        });
    </script>
@endsection