@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('body-class', 'register')

@section('content')
<div class="register-container">
    <!-- Logo section OUTSIDE the card -->
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="LoanHub Logo" class="logo">
        <h2 class="brand">LoanHub</h2>
        <p class="tagline">Get instant loans with best rates</p>
    </div>

    <!-- Register card -->
    <div class="register-card">
        <h3 class="form-title">Create Account</h3>

        <form class="register-form" id="registerForm">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" id="fullName" placeholder="Enter your full name" required>
            </div>
            <div class="input-group">
                <label>Mobile Number</label>
                <input type="tel" id="mobileNumber" placeholder="Enter mobile number" required>
            </div>
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" id="email" placeholder="Enter email address" required>
            </div>
            <div class="input-group">
                <label>PAN Number <span class="optional">(Optional)</span></label>
                <input type="text" id="panNumber" placeholder="Enter PAN number">
            </div>
            <div class="input-group">
                <label>Referral Code <span class="optional">(Optional)</span></label>
                <input type="text" id="referralCode" placeholder="Enter referral code">
            </div>

            <button type="submit" class="btn-primary-otp">Continue with OTP Verification</button>

            <div class="otp-info">
                <div class="icon"><img src="{{ asset('images/Vector.png') }}" alt="Vector Logo"></div>
                <div class="opt-info-text">
                    <strong>OTP Verification Options</strong>
                    <ul>
                        <li>Aadhaar linked mobile (Instant verification)</li>
                        <li>General mobile verification</li>
                    </ul>
                </div>
            </div>

            <p class="signin-text">Already have an account? <a href="#">Sign In</a></p>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/register.js') }}"></script>
@endpush
