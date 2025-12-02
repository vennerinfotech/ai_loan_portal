@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cibil_credit_score.css') }}">
@endsection

@section('body-class', 'verification-processing-page')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="credit-card-summary p-4">

        <div class="flex-grow-1">
            <h5 class="card-title fw-bold mb-4">
                Credit Report Summary
                <div class="underline-custom"></div>
            </h5>

            <div class="text-center my-4 pt-3 score">
                <h1 class="display-3 fw-bold mb-0 credit-score">750</h1>
                <p class="text-muted fs-6" style="margin-top: 5px;">out of 900</p>
            </div>

            <div class="text-center mb-5">
                <span class="badge credit-badge-excellent">
                    <i class="bi bi-check-circle-fill me-1"></i> Excellent
                </span>
            </div>

            <div class="row g-3 details-row mb-4">
                <div class="col-6 d-flex align-items-center text-muted">
                    <i class="bi bi-calendar-check me-2 credit-icon"></i>
                    Report Date
                </div>
                <div class="col-6 text-end fw-semibold">
                    Dec 15, 2024
                </div>

                <div class="col-6 d-flex align-items-center text-muted">
                    <i class="bi bi-building me-2 credit-icon"></i>
                    Bureau Source
                </div>
                <div class="col-6 text-end fw-semibold">
                    CIBIL
                </div>
            </div>
        </div>

        <div class="d-grid gap-3 d-sm-flex justify-content-center pt-3 mt-auto">
            <button class="btn credit-btn-gradient flex-fill py-2">
                <i class="bi bi-file-earmark-text me-1"></i> View Full Report
            </button>
            <button class="btn credit-btn-continue flex-fill py-2">
                <i class="bi bi-check me-1"></i> Continue
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cibil_credit_score.js') }}"></script>
@endpush
