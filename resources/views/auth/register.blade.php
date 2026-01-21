@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
    <div class="form-container-wrapper">
        <div class="container">
            <div class="form-container">
                <div class="left-section">
                    <div class="content">
                        <img src="{{ asset('images/logo-1.png') }}" alt="Logo" class="logo-image">
                        <h3>Begin Your Loan Application Today</h3>
                    </div>
                </div>
                <div class="form-card">
                    <h3 class="form-title">Create Account</h3>
                    <p>Fill in your details to get started with secure verification</p>
                    <form class="register-form" method="POST" action="{{ route('register.store') }}" id="registerForm">
                        @csrf
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" id="fullName" class="form-control" placeholder="Enter your full name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="tel" name="phone" id="mobileNumber" class="form-control" placeholder="Enter mobile number"
                                value="{{ old('phone') }}" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email Address <span class="optional">(Optional)</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Referral Code <span class="optional">(Optional)</span></label>
                            <input type="text" name="reference_code" id="referralCode" class="form-control" placeholder="Enter referral code"
                                value="{{ old('reference_code') }}">
                            @error('reference_code')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit" id="form-submit">Continue with OTP
                            Verification</button>

                        <p class="signin-text">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/register.js') }}"></script>
@endpush
