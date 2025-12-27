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
                            <h3 class="mt-4">Enter Aadhaar Number</h3>
                            <p>We need to verify your identity to process your loan application securely</p>
                        </div>
                    <div class="aadhaar-container">
                        <div class="aadhaar-card">

                            <form class="aadhaar-form" method="POST" action="{{ route('store-aadhaar') }}">
                                @csrf

                                <!-- Success and Error Messages -->
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="aadhaar">Aadhaar Number (12 digits)</label>
                                    <div class="aadhaar-input-container">
                                        <input type="text" id="aadhaar" name="aadhaar_number"
                                            placeholder="XXXX XXXX XXXX" maxlength="12" autocomplete="off"
                                            class="form-control" value="{{ old('aadhaar_number') }}">


                                        <!-- Show validation error for aadhaar_number field -->
                                        @error('aadhaar_number')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <button type="button" class="aadhaar-toggle-visibility" id="toggleBtn">
                                            <i class="bi bi-shield-shaded"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="aadhaar-security-note">
                                    <div class="icon"><img src="{{ asset('images/lock.png') }}" alt="Vector Logo"></div>
                                    <span>Your data is encrypted and secure</span>
                                </div>

                                <button type="submit" class="btn-submit" id="continueBtn">Continue</button>
                            </form>

                            <!-- Security info -->
                            {{-- <div class="aadhaar-security-info">
                                <div class="aadhaar-security-item">
                                    <div class="icon"><img src="{{ asset('images/security-info.png') }}"
                                            alt="Vector Logo"></div>
                                    <div>
                                        <h3>Bank-grade Security</h3>
                                        <p>Your Aadhaar information is processed securely and never stored on our servers
                                        </p>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <!-- Footer -->
                        {{-- <div class="aadhaar-footer">
                            <div class="aadhaar-trust-indicators">
                                <span class="aadhaar-trust-text">Trusted by 2M+ customers</span>
                                <div class="aadhaar-ratings">
                                    <div class="aadhaar-rating">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <polygon
                                                points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                        </svg>
                                        <span>4.8/5 Rating</span>
                                    </div>
                                    <div class="aadhaar-ssl">
                                        <div class="icon"><img src="{{ asset('images/SSL.svg') }}" alt="Vector Logo">
                                        </div>
                                        <span>SSL Secured</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/aadhaar.js') }}"></script>
@endpush
