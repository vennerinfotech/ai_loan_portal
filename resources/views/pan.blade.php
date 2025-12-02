@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pan.css') }}">
@endsection

@section('body-class', 'verifications-page')

@section('content')
<div class="verifications-container">
    <div class="verifications-card">
        <div class="verifications-header">
            <div class="verifications-icon">
                {{-- Using a generic user/identity icon to match the screenshot's concept --}}
                <div class="icon">
                    <img src="{{ asset('images/aadhaar-icon.png') }}" alt="User Icon">
                </div>
            </div>
            <h1>Enter Your PAN Number</h1>
            <p class="verifications-subtitle">We need to verify your identity to proceed with your loan application</p>
        </div>

        <form class="verifications-form" id="panForm">
            <div class="verifications-input-group">
                <label for="pan">PAN Number</label>
                <div class="verifications-input-container">
                    {{-- Input field for PAN Number --}}
                    <input type="text" id="pan" placeholder="ABCDE1234F" maxlength="10" autocomplete="off" required>
                    {{-- Info icon matching the screenshot --}}
                    <div class="input-info-tooltip" data-tooltip="Enter your 10-digit PAN number as shown on your PAN card"><i class="bi bi-shield-shaded"></i></div>
                </div>
                {{-- Helper text for the PAN input --}}

                <p class="input-help-text"><i class="bi bi-info-circle-fill" style="margin-right:6px;"></i>Enter your
                    10-digit PAN number as shown on your PAN card</p>
            </div>

            {{-- Security Box matching the screenshot --}}
            <div class="verifications-security-box">
                <div class="icon">
                    <img src="{{ asset('images/lock.png') }}" alt="Lock Icon" style="width: 16px; height: 16px;">
                </div>
                <div>
                    <strong>Secure & Encrypted</strong>
                    <p>Your information is protected with bank-grade security</p>
                </div>
            </div>

            <button type="submit" class="verifications-continue-btn" id="continueBtn">Continue &rarr;</button>

            <div class="verifications-help-link">
                <i class="bi bi-question-circle-fill" style="color: #4285f4;"></i>
                <a href="#" id="helpLink">Need Help?</a>
            </div>
        </form>
    </div>

    <div class="verifications-process-card">
        <div class="process-step checked current">
            <div class="step-check"><i class="bi bi-check2"></i></div>
            <span>PAN Number verifications</span>
        </div>
        <div class="process-step">
            <div class="step-number">2</div>
            <span>Income verifications</span>
        </div>
        <div class="process-step">
            <div class="step-number">3</div>
            <span>Loan Approval</span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pan.js') }}"></script>
@endpush
