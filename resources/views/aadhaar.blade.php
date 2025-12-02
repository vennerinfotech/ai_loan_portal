@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/aadhaar.css') }}">
@endsection

@section('body-class', 'aadhaar')

@section('content')
<div class="aadhaar-container">
    <div class="aadhaar-card">
        <!-- Header with icon -->
        <div class="aadhaar-header">
            <div class="aadhaar-icon">
                <div class="icon"><img src="{{ asset('images/aadhaar-icon.png') }}" alt="Vector Logo"></div>
            </div>
            <h1>Enter Your Aadhaar Number</h1>
            <p class="aadhaar-subtitle">We need to verify your identity to process your loan application securely</p>
        </div>

        <!-- Form -->
        <form class="aadhaar-form">
            <div class="aadhaar-input-group">
                <label for="aadhaar">Aadhaar Number (12 digits)</label>
                <div class="aadhaar-input-container">
                    <input type="text" id="aadhaar" placeholder="XXXX XXXX XXXX" maxlength="14" autocomplete="off" required>
                    <button type="button" class="aadhaar-toggle-visibility" id="toggleBtn">
                        <i class="bi bi-shield-shaded"></i>
                    </button>
                </div>
            </div>

            <div class="aadhaar-security-note">
                <div class="icon"><img src="{{ asset('images/lock.png') }}" alt="Vector Logo"></div>
                <span>Your data is encrypted and secure</span>
            </div>

            <button type="submit" class="aadhaar-continue-btn" id="continueBtn">Continue</button>

            <div class="aadhaar-help-link">
                <i class="bi bi-question-circle-fill" style="color: rgba(37, 99, 235, 1)"></i>
                <a href="#" id="helpLink">Need Help?</a>
            </div>
        </form>

        <!-- Security info -->
        <div class="aadhaar-security-info">
            <div class="aadhaar-security-item">
                <div class="icon"><img src="{{ asset('images/security-info.png') }}" alt="Vector Logo"></div>
                <div>
                    <h3>Bank-grade Security</h3>
                    <p>Your Aadhaar information is processed securely and never stored on our servers</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div class="aadhaar-footer">
        <div class="aadhaar-trust-indicators">
            <span class="aadhaar-trust-text">Trusted by 2M+ customers</span>
            <div class="aadhaar-ratings">
                <div class="aadhaar-rating">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                    </svg>
                    <span>4.8/5 Rating</span>
                </div>
                <div class="aadhaar-ssl">
                    <div class="icon"><img src="{{ asset('images/SSL.svg') }}" alt="Vector Logo"></div>
                    <span>SSL Secured</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/aadhaar.js') }}"></script>
@endpush
