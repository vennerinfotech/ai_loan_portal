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
                            <p>Your PAN details are encrypted with industry-standard protocols ensuring complete privacy
                                and security.</p>
                        </div>

                    </div>
                </div>
                <div class="form-card">
                    <div class="mb-4">
                            <div class="icon-circle">
                                <i class="fa-solid fa-address-card"></i>
                            </div>
                            <h3 class="mt-4">Enter Your PAN Number</h3>
                            <p>We need to verify your identity to proceed with your loan application</p>
                        </div>
                        <form class="verifications-form" id="panForm" method="POST" action="{{ route('pancard.store') }}">
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
                    <label for="pan">PAN Number</label>
                    <div class="verifications-input-container">
                        {{-- Input field for PAN Number --}}
                        <input type="text" id="pan" name="pan_card_image" placeholder="ABCDE1234F" maxlength="10" class="form-control"
                            autocomplete="off">
                        {{-- Info icon matching the screenshot --}}
                        <div class="input-info-tooltip"
                            data-tooltip="Enter your 10-digit PAN number as shown on your PAN card"><i
                                class="bi bi-shield-shaded"></i></div>
                    </div>
                    {{-- Helper text for the PAN input --}}

                    <p class="input-help-text"><i class="bi bi-info-circle-fill" style="margin-right:6px;"></i>Enter
                        your
                        10-digit PAN number as shown on your PAN card</p>
                </div>

                <button type="submit" class="btn-submit" id="continueBtn">Continue &rarr;</button>

            </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/pan.js') }}"></script>
@endpush
