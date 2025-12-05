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
            {{-- @if ($errors->any())
                <script>
                    alert("{{ implode('\n', $errors->all()) }}");
                </script>
            @endif --}}

            <form class="register-form" method="POST" action="{{ route('register.store') }}" id="registerForm">
                @csrf
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" id="fullName" placeholder="Enter your full name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label>Mobile Number</label>
                    <input type="tel" name="phone" id="mobileNumber" placeholder="Enter mobile number"
                        value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter email address"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label>PAN Number <span class="optional">(Optional)</span></label>
                    <input type="text" name="pan_card_number" id="panNumber" placeholder="Enter PAN number"
                        value="{{ old('pan_card_number') }}">
                    @error('pan_card_number')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label>Referral Code <span class="optional">(Optional)</span></label>
                    <input type="text" name="reference_code" id="referralCode" placeholder="Enter referral code"
                        value="{{ old('reference_code') }}">
                    @error('reference_code')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary-otp" id="form-submit">Continue with OTP Verification</button>

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

                <p class="signin-text">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/register.js') }}"></script>
@endpush
