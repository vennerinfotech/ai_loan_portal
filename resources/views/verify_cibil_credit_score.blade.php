@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/verify_cibil_credit_score.css') }}">
@endsection

@section('body-class', 'verification-processing-page')

@section('content')
<div class="page-container">
    <div class="bg-shape top-left bg-blue-light"></div>
    <div class="bg-shape top-right bg-green-light"></div>
    <div class="bg-shape bottom-center bg-pink-light"></div>

    <div class="success-card">
        <div class="card-content">

            <div class="success-icon-bg">
                <i class="fas fa-check text-white"></i>
            </div>

            <h3 class="card-title">
                Credit Report Verified Successfully
            </h3>

            <p class="card-description">
                Your credit report has been fetched and analyzed. You <br> can now continue with your loan
                application.
            </p>

            <a href="/loan-application" class="action-button primary-btn">
                Proceed to Loan Application
            </a>

            <a href="/credit-report-details" class="view-details-link">
                View Credit Report Details
            </a>

            <div class="security-note">
                <i class="fas fa-lock security-lock-icon"></i> Your data is encrypted and secure
            </div>
        </div>
    </div>
    <div class="progress-dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</div>
@endsection

@push('scripts')
{{-- <script src="{{ asset('js/verify_pan.js') }}"></script> --}}
@endpush
