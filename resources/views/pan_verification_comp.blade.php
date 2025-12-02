@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pan_verification_comp.css') }}">
@endsection

@section('body-class', '')

@section('content')
<div class="bg-circle bg-circle-tl"></div>
<div class="bg-circle bg-circle-tr"></div>
<div class="bg-circle bg-circle-bl"></div>
<div class="bg-circle bg-circle-br"></div>

<div class="card p-4 text-center custom-card shadow-lg">
    <div class="icon-circle mx-auto mb-3">
        <i class="bi bi-check-lg custom-icon"></i>
    </div>

    <h5 class="fw-bold mb-2">PAN Verification Successful</h5>

    <p class="text-muted small mb-4">
        Your PAN details have been verified and saved securely.
    </p>

    {{-- <button class="btn custom-btn w-100 mb-4">Continue</button> --}}

    <a href="{{ route('cibil_crifr') }}" class="btn custom-btn w-100 mb-4">
        Continue
    </a>

    <div class="d-flex align-items-center justify-content-center small text-muted security-info">
        <i class="bi bi-lock-fill me-1"></i>
        <span>Verified securely with 256-bit encryption</span>
    </div>
</div>

<div class="text-center small next-step-text">
    Next: Income verification and loan application
</div>

@endsection

@push('scripts')
{{--
    <script src="{{ asset('js/pan.js') }}"></script> --}}
@endpush
