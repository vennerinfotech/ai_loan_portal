@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/verify_aadhaar_otp.css') }}">
@endsection

@section('body-class', 'verify-aadhaar-otp')

@section('content')
<div class="aadhaar-bg d-flex justify-content-center align-items-center vh-100">
    <div class="otp-card shadow-lg">

        <!-- Icon -->
        <div class="text-center mt-3">
            <div class="icon-box">
                <i class="bi bi-shield-lock-fill fs-3 text-primary"></i>
            </div>

            <h4 class="fw-semibold mt-2">Verify Your Aadhaar</h4>
            <p class="text-muted small">Enter the OTP sent to your registered mobile number</p>
        </div>

        <form action="{{ route('verify.otp') }}" method="POST" id="otpForm">
            @csrf

            <!-- OTP Boxes -->
            <div class="d-flex justify-content-center gap-2 my-3">
                @for ($i = 0; $i < 6; $i++) <input type="text" maxlength="1" name="otp[]" class="otp-box text-center" required>
                    @endfor
            </div>

            <!-- Verify Button -->
            <button class="verify-btn w-100">Verify OTP</button>

            <!-- Resend OTP -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    Resend OTP in <span id="timer" class="text-danger fw-semibold">30</span> s
                </small>
                <br>
                <a id="resend-otp" class="resend-link">Resend OTP</a>
            </div>

            <!-- Security Note -->
            <div class="text-center mt-3 mb-2">
                <small class="text-muted">
                    <i class="bi bi-lock-fill me-1"></i>
                    Your information is secure and encrypted
                </small>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/verify_aadhaar_otp.js') }}"></script>
@endpush
