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
                        <h3>Confirm Your Number for Loan Processing</h3>
                    </div>
                </div>
                <div class="form-card">
                    <div class="otp-cards">
                        <div class="icon-circle">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>

                        <h3 class="mt-3">Verify Your Account</h3>
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

                            <button type="submit" class="btn-submit">Verify Code</button>

                            <div class="extra-links">
                                <p>Didn’t receive the code? <a href="#" id="resend"> Resend Code</a></p>
                                <a href="/" class="change-number"><img src="{{ asset('images/pencil.png') }}"
                                        alt="Vector Logo">
                                    Change phone number</a>
                            </div>

                            <div class="security-note">
                                <p>For your security, this code will expire in 2 minutes.<br>
                                    Don’t share this code with anyone.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/verify_otp.js') }}"></script>
@endpush
