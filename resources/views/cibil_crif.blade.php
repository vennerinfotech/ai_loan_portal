@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cibil_crif.css') }}">
@endsection

@section('body-class', '')

@section('content')
<div class="full-page-overlay">
    <div class="card custom-card">

        <div class="text-center">
            <div class="header-icon-container">
                <i class="bi bi-question-circle-fill"></i>
            </div>
        </div>

        <h5 class="card-title text-center">Fetch Your Credit Report</h5>
        <p class="card-text text-center mb-4">
            We will securely fetch your credit report (CIBIL/CRIF) using your verified PAN number. This will not
            affect your credit score.
        </p>

        <div class="pan-input-group-container">
            <p class="pan-label">Verified PAN Number</p>
            <div class="pan-input-row">
                <input type="text" id="panNumber" class="form-control fw-bold" value="ABCDE1234F" readonly>
                <div class="pan-check-icon-wrapper">
                    <div class="pan-check-badge">
                        <i class="bi bi-check-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <ul class="list-unstyled">
            <li class="d-flex align-items-center">
                <i class="bi bi-lock-fill me-3"></i>
                256-bit SSL encryption
            </li>
            <li class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3"></i>
                No impact on credit score
            </li>
            <li class="d-flex align-items-center">
                <i class="bi bi-clock-fill me-3"></i>
                Instant report generation
            </li>
        </ul>

        <div class="d-grid">
            <button class="btn btn-primary btn-lg" id="agreeAndContinue">
                <i class="bi bi-check-lg me-2"></i>
                I Agree & Continue
            </button>
            <button class="btn btn-cancel fw-normal" id="cancel">
                <i class="bi bi-x-lg me-2"></i>
                Cancel
            </button>
        </div>

        <div class="text-center small compliance-footer">
            <span class="badge text-blue"><i class="bi bi-shield-fill-check me-1"></i> RBI Compliant</span>
            <span class="badge text-green"><i class="bi bi-lock-fill me-1"></i> Data Protected</span>
            <span class="badge text-yellow"><i class="bi bi-patch-check-fill me-1"></i> ISO Certified</span>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cibil_crif.js') }}"></script>
@endpush
