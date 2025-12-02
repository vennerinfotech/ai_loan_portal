@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pan_data_review.css') }}">
@endsection

@section('body-class', 'align-items-center')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5" style="padding: 20px;">

    <div class="card custom-card-shadow">
        <div class="card-body">

            <div class="text-center mb-4">
                <div class="pan-icon-circle mx-auto mb-3">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h5 class="card-title fw-bold">Review Your PAN Details</h5>
                <p class="card-subtitle text-muted" style="font-size: 0.9rem;">Please verify your information before
                    submitting</p>
            </div>

            <form id="panReviewForm">
                <div class="mb-3">
                    <label for="fullName" class="form-label field-label">Full Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control field-input" id="fullName" value="RAJESH KUMAR SHARMA" readonly>
                        <span class="input-group-text field-edit-icon" onclick="enableEdit('fullName')">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label field-label">Date of Birth</label>
                    <div class="input-group">
                        <input type="text" class="form-control field-input" id="dob" value="15/03/1985" readonly>
                        <span class="input-group-text field-edit-icon" onclick="enableEdit('dob')">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="fatherName" class="form-label field-label">Father's Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control field-input" id="fatherName" value="MOHAN LAL SHARMA" readonly>
                        <span class="input-group-text field-edit-icon" onclick="enableEdit('fatherName')">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="panNumber" class="form-label field-label">PAN Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control field-input" id="panNumber" value="ABCDE1234F" readonly>
                        <span class="input-group-text field-edit-icon" onclick="enableEdit('panNumber')">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                    </div>
                </div>
            </form>

            <div class="alert alert-info custom-alert-info mb-4" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34-.34.65-.73.65-.291 0-.583-.16-.763-.448a1.036 1.036 0 0 1-.144-.817l1-4.705c.07-.34.34-.65.73-.65.291 0 .583.16.763.448.18.288.144.607.144.817z" />
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
                <button id="confirmSubmitBtn" class="btn btn-primary custom-btn-primary fw-bold" type="submit" form="panReviewForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06-.011z" />
                    </svg>
                    Confirm & Submit
                </button>
            </div>
            <div class="d-grid">
                <button id="editDetailsBtn" class="btn custom-btn-light fw-bold" type="button">
                    <i class="bi bi-pencil-square"></i>
                    Edit Details
                </button>
            </div>

            <div class="text-center">
                <p class="small security-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h6a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5z" />
                    </svg>
                    Your data is encrypted and secure
                </p>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pan_data_review.js') }}"></script>
@endpush
