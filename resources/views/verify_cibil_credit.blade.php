@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/verify_cibil_credit.css') }}">
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
                            <h4>Credit Report</h4>
                            <p>Get your latest credit report in seconds. Check your score and understand your financial
                                standing.</p>
                        </div>

                    </div>
                </div>
                <div class="form-card">
                    <div class="mb-4">
                        <div class="loading-icon-container">
                            <div class="loading-outer-ring"></div>
                            <i class="fa-regular fa-file"></i>
                        </div>
                        <h3 class="mt-4">Fetching Your Credit Report...</h3>
                        <p>We are securely connecting with CIBIL/CRIF servers.</p>
                    </div>
                    <div class="progress-bar-container">
            <div class="progress" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 50%"></div>
            </div>
        </div>
        <span class="security-text">
            <i class="bi bi-lock-fill"></i> Secure 256-bit encryption
        </span>

        <div class="status-box">
            <div class="status-header">
                <span>Processing Status</span>
                <span>In Progress</span>
            </div>

            <ul class="processing-list">
                <li>Identity verification completed</li>
                <li>Connecting to credit bureau</li>
                <li>Generating detailed report</li>
            </ul>
        </div>

        <p class="footer-disclaimer">
            This process typically takes 30-60 seconds. Please do not close this window.
        </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/verify_cibil_credit.js') }}"></script>
@endpush
