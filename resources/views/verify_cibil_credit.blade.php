@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/verify_cibil_credit.css') }}">
@endsection

@section('body-class', 'verification-processing-page')

@section('content')
<div class="processing-container">

    <div class="loading-icon-container">
        <div class="loading-outer-ring"></div>
        <i class="bi bi-file-earmark-bar-graph-fill"></i>
    </div>

    <h1 class="processing-title">Fetching Your Credit Report...</h1>
    <p class="processing-subtitle">
        We are securely connecting with CIBIL/CRIF servers.
    </p>

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
@endsection

@push('scripts')
<script src="{{ asset('js/verify_cibil_credit.js') }}"></script>
@endpush
