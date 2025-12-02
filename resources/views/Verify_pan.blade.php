@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/verify_pan.css') }}">
@endsection

@section('body-class', 'verification-processing-page')

@section('content')
<div class="verification-container">
    <div class="processing-card">
        <div class="processing-header">
            <div class="processing-icon">
                {{-- Shield icon for identity verification --}}
                <img src="{{ asset('images/shield-icon.png') }}" alt="Shield Icon">
            </div>
            <h1>Identity Verification</h1>
            <p class="processing-subtitle">securing your loan application</p>
        </div>
        <div class="spinners"></div>
        <div class="progress-bar-container">
            <div class="progress-bar">
                {{-- This segment represents the currently filled part (Processing) --}}
                <div class="progress-fill" style="width: 66%;"></div>
            </div>
            <div class="progress-labels">
                <span>Validating</span>
                <span class="processing-label">Processing</span>
                <span>Verified</span>
            </div>
        </div>

        <div class="verification-text">
            <h2>Verifying your PAN number with Income Tax database...</h2>
            <p class="wait-text">Please wait<span class="dot-animation">..</span></p>
        </div>

        <div class="secure-verification-box">
            <div class="icon">
                <img src="{{ asset('images/lock.png') }}" alt="Lock Icon" style="width: 16px; height: 16px;">
            </div>
            <div>
                <strong>Secure Verification</strong>
                <p>Your information is encrypted and verified through official government databases. This process
                    typically takes 30-60 seconds.</p>
            </div>
        </div>

        <div class="verification-checklist">
            <div class="checklist-item completed">
                <i class="bi bi-check-circle-fill"></i>
                <span>PAN format validated</span>
            </div>
            <div class="checklist-item processing">
                <div class="spinner"></div>
                <span>Connecting to Income Tax database</span>
            </div>
            <div class="checklist-item">
                <div class="empty-circle"></div>
                <span>Verifying identity details</span>
            </div>
        </div>

        <p class="footer-security-note"> <img src="{{ asset('images/SSL.svg') }}" alt="Lock Icon" style="margin-bottom:2px;"> Protected by 256-bit SSL encryption</p>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/verify_pan.js') }}"></script>
@endpush
