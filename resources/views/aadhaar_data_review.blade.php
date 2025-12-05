@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/aadhaar_data_review.css') }}">
@endsection

@section('body-class', 'review')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="review-container w-100">

        <div class="text-center mb-4" id="formHeader">
            <div class="header-icon">
                <i class="bi bi-file-earmark-person-fill" style="font-size: 1.5rem;"></i>
            </div>
            <h4 class="fw-bold mb-2">Review Your Aadhaar Details</h4>
            <p class="text-muted">Please verify and confirm your information before proceeding</p>
        </div>

        <div id="successMessage" class="text-center review-card">
            <div class="header-icon" style="background-color: #e6ffed; color: #198754;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
            </div>
            <h4 class="fw-bold mb-2" style="color: #198754;">Submission Successful! 🎉</h4>
            <p class="text-muted">Your Aadhaar details have been successfully verified and submitted for processing.
            </p>
            <button class="btn btn-primary mt-3" onclick="resetForm()">Go Back to Dashboard</button>
        </div>

        <div class="review-card">
            <form id="aadhaarForm">

                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <div class="input-group-field">
                        <input type="text" class="form-control" id="fullName" value="Rajesh Kumar Sharma" readonly>
                        <i class="bi bi-person input-icon"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <div class="input-group-field">
                        <input type="text" class="form-control" id="dob" value="1985-03-15" readonly>
                        <i class="bi bi-calendar input-icon"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-group-field">
                        <textarea class="form-control" id="address" rows="3" readonly>123, MG Road, Block A, Sector 15, New Delhi - 110001</textarea>

                        <i class="bi bi-geo-alt input-icon textarea-icon"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" disabled>
                        <option selected>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="aadhaar" class="form-label">Aadhaar Number</label>
                    <div class="input-group-field">
                        <input type="text" class="form-control" id="aadhaar" value="**** **** 5678" readonly>
                        <i class="bi bi-lock input-icon"></i>
                    </div>
                    <small class="text-muted mt-1 d-block" style="font-size: 0.8rem;">Aadhaar number is masked for
                        security</small>
                </div>

                <div class="verification-notice mb-4">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        <p class="mb-0">Verification Notice</p>
                        <span class="d-block">By confirming, you agree that the information provided is accurate and
                            complete. This data will be used for identity verification purposes only.</span>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-light d-flex align-items-center justify-content-center" onclick="handleBack()">
                        <i class="bi bi-arrow-left" style="margin-right: 5px;"></i>
                        Back to Edit
                    </button>

                    <a href="{{ route('aadhaar_verification_comp') }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                        Confirm & Submit
                    </a>
                </div>
            </form>
        </div>
        <div class="text-center security-footer" id="securityFooter">
            <i class="bi bi-shield-lock-fill" style="margin-right: 5px; color: #198754;"></i>
            Your data is encrypted and secure
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/aadhaar_verification_comp.js') }}"></script>
@endpush
