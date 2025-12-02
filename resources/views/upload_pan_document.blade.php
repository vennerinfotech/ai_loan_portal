@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/upload_pan_document.css') }}">
@endsection

@section('body-class', 'uploads')

@section('content')
<div class="pan-upload-card uploads">

    <div class="text-center mb-4">
        <div class="pan-icon-box mx-auto mb-2">
            <i class="bi bi-file-earmark-text"></i>
        </div>
        <h5 class="fw-bold mb-1">Upload PAN Document</h5>
        <p class="pan-upload-description">Please upload a clear image of your PAN card</p>
    </div>

    <div class="pan-secondary-card mb-4">
        <div class="pan-upload-area mb-3">
            <i class="bi bi-camera"></i>
            <p>Tap to take photo<br>or upload from gallery</p>
        </div>

        <div class="d-flex gap-2">
            <button class="btn pan-btn-primary w-50"><i class="bi bi-camera-fill me-1"></i>Take Photo</button>
            <button class="btn pan-btn-light w-50"><i class="bi bi-folder-fill me-1"></i>Gallery</button>
        </div>
    </div>


    <div class="pan-secondary-card pt-3">
        <div class="pan-instructions mb-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-info-circle-fill me-1"></i> Important Instructions</h6>

            <ul class="list-unstyled">
                <li class="mb-2">Ensure all four corners of the PAN card are visible</li>
                <li class="mb-2">Take photo in good lighting conditions</li>
                <li class="mb-2">Avoid shadows and reflections on the card</li>
                <li class="mb-2">Make sure text is clear and readable</li>
            </ul>
        </div>

        <div class="pan-sample-box mb-3">
            <h4 class="fw-semibold mb-3"><i class="bi bi-image-alt me-1"></i> Sample Photo Reference</h4>
            <div class="pan-sample-img-box">
                <img src="{{ asset('images/Sample.png') }}" class="img-fluid" alt="Sample PAN Card Photo">
                <p class="mt-2">Sample: Clear, well-lit Pan card photo</p>
            </div>
        </div>
    </div>


    <div class="pan-format-info mb-3 ps-2">
        <p class="small mb-1"><i class="bi bi-lightning-charge-fill me-2"></i>Accepted formats: JPG, PNG, PDF
        </p>
        <p class="small"><i class="bi bi-arrow-up-circle-fill me-2"></i>Maximum size: 10 MB</p>
    </div>

    <div class="pan-secure-box p-3 mb-4">
        <strong><i class="bi bi-shield-fill"></i>Secure Upload</strong>
        <p class="small mb-0">Your document is encrypted and stored securely. We use bank-level security to protect
            your information.</p>
    </div>

    <div class="d-flex gap-3">
        {{-- <button class="btn pan-btbuttonn-light border w-50">Cancel</button> --}}

        <a href="{{ route('pan') }}" class="btn pan-btbuttonn-light border w-50">
            Cancel
        </a>
        <a href="{{ route('pan_data_review') }}" class="btn pan-btn-success w-50">
            Continue
        </a>
    </div>

</div>
@endsection

@push('scripts')
{{--
    <script src="{{ asset('js/verify_aadhaar_otp.js') }}"></script> --}}
@endpush
