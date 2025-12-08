@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cibil_credit_score.css') }}">
@endsection

@section('body-class', 'verification-processing-page')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="credit-card-summary p-4">

        <div class="flex-grow-1">
            <h5 class="card-title fw-bold mb-4 text-center">
                Credit Report Summary
                <div class="underline-custom mx-auto"></div>
            </h5>

            <!-- Government Verify Badge -->
            <div class="text-center mb-3">
                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill">
                    <i class="bi bi-shield-fill-check me-2"></i> Government Verified Original Report
                </span>
            </div>

            <div class="text-center my-4 pt-3 score">
                <h1 class="display-3 fw-bold mb-0 credit-score" 
                    style="color: {{ $score >= 750 ? '#198754' : ($score >= 650 ? '#ffc107' : '#dc3545') }}">
                    {{ $score }}
                </h1>
                <p class="text-muted fs-6" style="margin-top: 5px;">out of 900</p>
            </div>

            <div class="text-center mb-5">
                @if($score >= 750)
                    <span class="badge credit-badge-excellent">
                        <i class="bi bi-check-circle-fill me-1"></i> Excellent
                    </span>
                @elseif($score >= 650)
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                        <i class="bi bi-dash-circle-fill me-1"></i> Good
                    </span>
                @else
                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> Needs Improvement
                    </span>
                @endif
            </div>

            <div class="row g-3 details-row mb-4">
                <div class="col-6 d-flex align-items-center text-muted">
                    <i class="bi bi-calendar-check me-2 credit-icon"></i>
                    Report Date
                </div>
                <div class="col-6 text-end fw-semibold">
                    {{ $reportDate }}
                </div>

                <div class="col-6 d-flex align-items-center text-muted">
                    <i class="bi bi-building me-2 credit-icon"></i>
                    Bureau Source
                </div>
                <div class="col-6 text-end fw-semibold">
                    {{ $provider }}
                </div>
            </div>
        </div>

        <div class="d-grid gap-3 d-sm-flex justify-content-center pt-3 mt-auto">
            <a href="{{ route('cibil.download.report') }}" class="btn credit-btn-gradient flex-fill py-2 text-decoration-none text-white">
                <i class="bi bi-file-earmark-text me-1"></i> View Full Report
            </a>
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
