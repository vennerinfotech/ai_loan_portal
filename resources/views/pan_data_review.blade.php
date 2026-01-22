@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pan_data_review.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
    <div class="form-container-wrapper">
        <div class="container">
            <div class="form-container">
                <div class="left-section">
                    <div class="content">
                        <img src="{{ asset('images/logo-1.png') }}" alt="Logo" class="logo-image">
                        <div class="info">
                            <h4>Secure Verification</h4>
                            <p>Your PAN details are encrypted with industry-standard protocols ensuring complete privacy
                                and security.</p>
                        </div>

                    </div>
                </div>
                <div class="form-card fix-height">
                    <div class="mb-4">
                        <div class="icon-circle">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <h3 class="mt-4">Review Your PAN Details</h3>
                        <p>Please verify your information before
                            submitting</p>
                    </div>
                    <form id="panReviewForm">
                        <div class="form-group">
                            <label for="fullName" class="form-label field-label">Full Name</label>
                            <input type="text" class="form-control field-input" id="fullName"
                                value="{{ $full_name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="dob" class="form-label field-label">Date of Birth</label>
                            <input type="text" class="form-control field-input" id="dob"
                                value="{{ $dob }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="fatherName" class="form-label field-label">Father's Name</label>
                            <input type="text" class="form-control field-input" id="fatherName"
                                value="{{ $father_name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="panNumber" class="form-label field-label">PAN Number</label>
                            <input type="text" class="form-control field-input" id="panNumber"
                                value="{{ $pan_number }}" readonly>
                        </div>
                    </form>
                    <div class="alert alert-info custom-alert-info mb-4" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34-.34.65-.73.65-.291 0-.583-.16-.763-.448a1.036 1.036 0 0 1-.144-.817l1-4.705c.07-.34.34-.65.73-.65.291 0 .583.16.763.448.18.288.144.607.144.817z" />
                        </svg>
                        <div class="alert-content">
                            <span class="alert-title">Important Notice</span>
                            <p class="alert-message mb-0">
                                Please ensure all details match exactly with your PAN card. Any discrepancy may cause
                                verification delays.
                            </p>
                        </div>
                    </div>
                    <div class="d-grid mb-2">
                        <button id="confirmSubmitBtn" class="btn-submit" type="submit" form="panReviewForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06-.011z" />
                            </svg>
                            Confirm & Submit
                        </button>
                    </div>
                    <div class="d-grid">
                        <button id="editDetailsBtn" class="btn-cancel" type="button">
                            <i class="bi bi-pencil-square"></i>
                            Edit Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="{{ asset('js/pan_data_review.js') }}"></script>
    @endpush
