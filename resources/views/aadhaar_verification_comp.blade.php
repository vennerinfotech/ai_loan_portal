@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/aadhaar_verification_comp.css') }}">
@endsection

@section('body-class', 'verification-card')

@section('content')
<div class="verification-container">

    <div class="text-center verification-card">

        <div class="check-circle-exact">
            <i class="bi bi-check-lg"></i>
        </div>

        <div class="text-header">Aadhaar Verification Successful</div>
        <div class="text-subheader">Your Aadhaar details have been verified and saved securely.</div>

        <div class="verification-label">
            <i class="bi bi-question-circle-fill"></i>
            Verification Complete
        </div>

        <div class="security-info">
            <div class="security-info-content">
                <i class="bi bi-lock-fill"></i>
                <span>Your information is encrypted and stored<br>securely in compliance with data protection
                    regulations.</span>
            </div>
        </div>

        <button class="btn btn-continue" onclick="continueAction()">
            Continue
        </button>
        <button class="btn btn-download-receipt" onclick="downloadReceipt()">
            <i class="bi bi-download"></i> Download Verification Receipt
        </button>
    </div>

    <div class="text-center help-footer">
        Need help? <a href="#" onclick="contactSupport()">Contact Support</a>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/aadhaar_verification_comp.js') }}"></script>
@endpush
