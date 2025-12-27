@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/verify_pan.css') }}">
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
                            <p>Your PAN details are encrypted with industry-standard protocols ensuring complete privacy
                                and security.</p>
                        </div>
                    </div>
                </div>
                <div class="form-card">
                    <div class="verification-container">
                        <div class="processing-card">
                            <div class="text-center mb-4">
                                <div class="icon-circle mx-auto">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <h3 class="mt-3">Identity Verification</h3>
                                <p>securing your loan application</p>
                            </div>
                            <div class="spinners"></div>
                            <div class="progress-bar-container">
                                <div class="progress-bar">
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
                                    <img src="{{ asset('images/lock.png') }}" alt="Lock Icon"
                                        style="width: 16px; height: 16px;">
                                </div>
                                <div>
                                    <strong>Secure Verification</strong>
                                    <p>Your information is encrypted and verified through official government databases.
                                        This process
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/verify_pan.js') }}"></script>
@endpush
