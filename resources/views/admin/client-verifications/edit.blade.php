@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.jobs.jobs-list') }}">Clients</a></li>
                            <li class="breadcrumb-item active">Client Verification Requests</li>
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
                    <form action="{{ route('admin.client-verifications.update', $client->id) }}" method="POST" id="editClientVerificationForm" name="editClientVerificationForm" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Update Client Verification Request</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="id" class="mb-2">Request ID</label>
                                        <input value="{{ $client->id }}" type="text" id="id" name="id" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6  mb-4">
                                        <label for="freelancer_id" class="mb-2">Client ID</label>
                                        <input value="{{ $client->user->id }}" type="text" id="freelancer_id" name="freelancer_id" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-4">
                                        <label for="firstName" class="mb-2">Client First Name</label>
                                        <input value="{{ $client->user->firstName }}" type="text" id="firstName" name="firstName" class="form-control" readonly>
                                    </div>
        
                                    <div class="mb-4 col-md-4">
                                        <label for="midName" class="mb-2">Client Middle Name</label>
                                        <input value="{{ $client->user->midName }}" type="text" id="midName" name="midName" class="form-control" readonly>
                                    </div>

                                    <div class="mb-4 col-md-4">
                                        <label for="lastName" class="mb-2">Client Last Name</label>
                                        <input value="{{ $client->user->lastName }}" type="text" id="lastName" name="lastName" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <div class="form-check">
                                            <input {{ ($client->isFeatured == 1) ? 'checked' : '' }} class="form-check-input" type="checkbox" value="1" id="isFeatured" name="isFeatured">
                                            <label class="form-check-label" for="isFeatured">
                                              Featured
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <div class="form-check-inline">
                                            <label for="isVerified" class="mb-2">Verification Status: </label>
                                            <input {{ ($client->isVerified == 1) ? 'checked' : '' }} class="form-check-input" type="radio" value="1" id="isVerified-active" name="isVerified">
                                            <label class="form-check-label" for="isVerified">
                                              Verified
                                            </label>
                                        </div>
                                        
                                        <div class="form-check-inline">
                                            <input {{ ($client->isVerified == 0) ? 'checked' : '' }} class="form-check-input" type="radio" value="0" id="isVerified-block" name="isVerified">
                                            <label class="form-check-label" for="isVerified">
                                              Pending
                                            </label>
                                        </div>                                      
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="valid_id" class="mb-2">Valid ID</label>
                                    <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light" style="cursor: pointer;">
                                        <img src="{{ $client->valid_id }}" class="w-100" id="openModal" />
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                                    </div>
                                </div>

                                <div class="modal fade" id="validIdModal" tabindex="-1" aria-labelledby="validIdModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{ $client->valid_id }}" class="w-100" alt="Client Valid ID" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="selfie_with_id" class="mb-2">Selfie with Valid ID</label>
                                    <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light" style="cursor: pointer;">
                                        <img src="{{ $client->selfie_with_id }}" class="w-100" id="openSelfieModal" />
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="business_permit" class="mb-2">Business Permit</label>
                                    <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light" style="cursor: pointer;">
                                        <img src="{{ $client->business_permit }}" class="w-100" id="openBusinessPermitModal" />
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="dti_registration" class="mb-2">DTI Registration</label>
                                    <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light" style="cursor: pointer;">
                                        <img src="{{ $client->dti_registration }}" class="w-100" id="opendtiRegistrationModal" />
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                                    </div>
                                </div>

                                <div class="modal fade" id="selfieModal" tabindex="-1" aria-labelledby="selfieModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{ $client->selfie_with_id }}" class="w-100" alt="Selfie with Valid ID" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="businessPermitModal" tabindex="-1" aria-labelledby="businessPermitModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{ $client->business_permit }}" class="w-100" alt="Business Permit" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="dtiRegistrationModal" tabindex="-1" aria-labelledby="dtiRegistrationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{ $client->dti_registration }}" class="w-100" alt="DTI Registration" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                

                                <div class="mb-4">
                                    <label for="sec_registration" class="mb-2">SEC Registration</label>
                                    <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light" style="cursor: pointer;">
                                        <img src="{{ $client->sec_registration }}" class="w-100" id="opensecRegistrationModal" />
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                                    </div>
                                </div>

                                <div class="modal fade" id="secRegistrationModal" tabindex="-1" aria-labelledby="secRegistrationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{ $client->sec_registration }}" class="w-100" alt="SEC Registration" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end pt-3">
                                    <button type="submit" class="btn btn-primary me-2">Update Request</button>
                                    <a href="{{ route('admin.freelancer-verifications.list') }}" class="btn btn-outline-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('openModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('validIdModal'));
            modal.show();
        });

        document.getElementById('openSelfieModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('selfieModal'));
            modal.show();
        });

        document.getElementById('openBusinessPermitModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('businessPermitModal'));
            modal.show();
        });

        document.getElementById('opendtiRegistrationModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('dtiRegistrationModal'));
            modal.show();
        });

        document.getElementById('opensecRegistrationModal').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('secRegistrationModal'));
            modal.show();
        });
    </script>
@endsection
