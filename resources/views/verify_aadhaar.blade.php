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
                        <div class="info">
                            <h4>Secure Verification</h4>
                            <p>Your Aadhaar details are encrypted with industry-standard protocols ensuring complete privacy
                                and security.</p>
                        </div>

                    </div>
                </div>
                <div class="form-card">
                    <div class="mb-4">
                        <div class="icon-circle">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <h3 class="mt-4">Verify Your Aadhaar</h3>
                        <p>Enter the OTP sent to your registered mobile number</p>
                    </div>

                    <form action="{{ route('verify.otp') }}" method="POST" id="otpForm">
                        @csrf

                        <!-- OTP Boxes -->
                        <div class="aadhar-otp-box mb-4">
                            @for ($i = 0; $i < 6; $i++)
                                <input type="text" maxlength="1" name="otp[]" class="otp-box text-center" required>
                            @endfor
                        </div>

                        <!-- Verify Button -->
                        <button type="button" class="btn-submit">Verify OTP</button>

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
        </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/verify_aadhaar_otp.js') }}"></script>
@endpush
