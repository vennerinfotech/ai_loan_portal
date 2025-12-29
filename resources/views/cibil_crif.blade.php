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
                            <h4>Credit Report</h4>
                            <p>Get your latest credit report in seconds. Check your score and understand your financial
                                standing.</p>
                        </div>

                    </div>
                </div>
                <div class="credit-score-list form-card">
                    <div class="mb-4">
                        <div class="icon-circle">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <h3 class="mt-4">Fetch Your Credit Report</h3>
                        <p>We will securely fetch your credit report (CIBIL/CRIF) using your verified PAN number. This will
                            not
                            affect your credit score.</p>
                    </div>
                    <div class="form-group">
                        <label>Verified PAN Number</label>
                        <input type="text" id="panNumber" class="form-control fw-bold" value="{{ $panNumber }}"
                            readonly>
                        <div class="pan-check-icon-wrapper">
                            <div class="pan-check-badge">
                                <i class="bi bi-check-lg"></i>
                            </div>
                        </div>
                    </div>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center">
                            <i class="fa-solid fa-lock"></i>
                            256-bit SSL encryption
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fa-solid fa-check"></i>
                            No impact on credit score
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fa-solid fa-clock"></i>
                            Instant report generation
                        </li>
                    </ul>
                    <div class="">
                        <button class="btn-submit" id="agreeAndContinue">
                            <i class="bi bi-check-lg me-2"></i>
                            I Agree & Continue
                        </button>
                        <button class="btn-cancel" id="cancel">
                            <i class="bi bi-x-lg me-2"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/cibil_crif.js') }}"></script>
@endpush
