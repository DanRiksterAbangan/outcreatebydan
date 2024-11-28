@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.jobs.jobs-list') }}">Contacts</a></li>
                            <li class="breadcrumb-item active">View Message</li>
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
                    <form action="#" method="POST" id="editVerificationForm" name="editVerificationForm" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">View Message</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="mb-2">Full Name</label>
                                        <input value="{{ $contact->name }}" type="text" id="name" name="name" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6  mb-4">
                                        <label for="email" class="mb-2">Email</label>
                                        <input value="{{ $contact->email }}" type="text" id="email" name="email" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <div class="mb-4">
                                        <label for="subject" class="mb-2">Subject</label>
                                        <input value="{{ $contact->subject }}" type="text" id="subject" name="subject" class="form-control text-center" readonly>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <div class="mb-4">
                                        <label for="message" class="mb-2">Message</label>
                                        <input value="{{ $contact->message }}" type="text" id="message" name="message" class="form-control text-center" readonly>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end pt-3">
                                    <a href="{{ route('chatify') }}" target="_blank" class="btn btn-primary me-2">Respond</a>
                                    <a href="{{ route('admin.contacts.contacts-list') }}" class="btn btn-outline-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
