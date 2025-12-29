@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cibil_credit_score.css') }}">
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
                        <div class="icon-circle">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h3 class="mt-4">Credit Report Summary</h3>
                    </div>
                    <div class="">
                        <span
                            class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill">
                            <i class="bi bi-shield-fill-check me-2"></i> Government Verified Original Report
                        </span>
                    </div>
                    <div class="credit-score">
                        <h4>
                            {{ $score }} <span> / 900</span>
                        </h4>
                    </div>
                    <div class="">
                        @if ($score >= 750)
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
                    <div class="credit-details-row">
                        <div>
                            <h6 class="">
                                <i class="fa-solid fa-calendar"></i>
                                Report Date:
                            </h6>
                            <p class="">
                                {{ $reportDate }}
                            </p>
                        </div>

                        <div>
                            <h6 class="">
                                <i class="fa-solid fa-building-columns"></i>
                                Bureau Date:
                            </h6>
                            <p class="">
                                {{ $provider }}
                            </p>
                        </div>
                    </div>
                    <button class="btn-submit">
                            <i class="fa-solid fa-check me-1"></i> Continue
                        </button>
                     <a href="{{ route('cibil.download.report') }}"
                            class="btn-cancel">
                            <i class="fa-solid fa-file me-1"></i> View Full Report
                        </a>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/cibil_credit_score.js') }}"></script>
@endpush
