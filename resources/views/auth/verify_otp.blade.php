@extends('layouts.app')

@section('styles')
     <link rel="stylesheet" href="{{ asset('css/verify_otp.css') }}">
@endsection

@section('body-class', 'verify_otp')

@section('content')
    <div class="otp-container">
        <div class="otp-cards">
            <div class="otp-icon">
                <img src="{{ asset('images/shield.png') }}" alt="Security Icon">
            </div>

            <h2 class="otp-title">Verify Your Account</h2>
            <p class="otp-subtitle">
                We've sent a 6-digit code to <br>
                <strong id="mobileDisplay">+1 (555) 123-4567</strong>
            </p>

            <form class="otp-form" id="otpForm">
                <div class="otp-inputs">
                    <input type="text" maxlength="1" class="otp-digit" required>
                    <input type="text" maxlength="1" class="otp-digit" required>
                    <input type="text" maxlength="1" class="otp-digit" required>
                    <input type="text" maxlength="1" class="otp-digit" required>
                    <input type="text" maxlength="1" class="otp-digit" required>
                    <input type="text" maxlength="1" class="otp-digit" required>
                </div>

                <div class="timer-section">
                    <p>Code expires in <br> <span id="timer">02:00</span></p>
                </div>

                <button type="submit" class="btn-primary">Verify Code</button>

                <div class="extra-links">
                    <p>Didn’t receive the code? <br><br> <a href="#" id="resend">Resend Code</a></p>
                    <a href="/" class="change-number"><img src="{{ asset('images/pencil.png') }}" alt="Vector Logo"> Change
                        phone number</a>
                </div>

                <div class="security-note">
                    {{-- <i class="fa-solid fa-circle-info" style="color: #2a63ea;"></i> --}}
                    <p>For your security, this code will expire in 2 minutes.<br>
                        Don’t share this code with anyone.</p>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/verify_otp.js') }}"></script>
@endpush
