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
                    <div class="mb-4 text-center">

                        <div class="icon-circle mx-auto">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <h3 class="mt-3">Aadhaar Verification Successful</h3>
                        <p>Your Aadhaar details have been verified and saved securely.</p>

                        <div class="verification-label">
                            <i class="bi bi-question-circle-fill"></i>
                            Verification Complete
                        </div>

                        <div class="security-info">
                            <div class="security-info-content">
                                <i class="bi bi-lock-fill"></i>
                                <span>Your information is encrypted and stored<br>securely in compliance with data
                                    protection
                                    regulations.</span>
                            </div>
                        </div>

                        <button class="btn-submit" onclick="continueAction()">
                            Continue
                        </button>

                        <button class="btn btn-download-receipt"
                            onclick="window.location.href='{{ route('aadhaar.downloadReceipt') }}'">
                            <i class="bi bi-download"></i> Download Verification Receipt
                        </button>

                    </div>

                    <div class="text-center help-footer">
                        Need help? <a href="#" onclick="contactSupport()">Contact Support</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/aadhaar_verification_comp.js') }}"></script>
@endpush
