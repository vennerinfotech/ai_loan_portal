@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/document-locker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

    </style>
@endsection

@section('content')
    <div class="document-wrapper">
        <div class="container">

            <div class="locker-header">
                <div class="header-content">
                    <div class="logo-section">
                        <div class="logo">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h1>My Document Locker</h1>
                            <p>Secure storage for your verified financial documents</p>
                        </div>
                    </div>
                </div>

                <div class="user-meta">
                    <div class="meta-item">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ $user->name }}</span>
                    </div>
                    @if (isset($document) && $document)
                        <div class="meta-item">
                            <i class="fas fa-file-contract"></i>
                            <span>Doc Ref: {{ $document->customer_id ?? 'N/A' }}</span>
                        </div>
                    @endif
                </div>

                <a href="{{ route('dashboard') }}" class="custom-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>

            @if (isset($document) && $document)
                <!-- Document Cards -->
                <div class="documents-grid">
                    <!-- Aadhaar Card -->
                    <div class="doc-card">
                        @if ($document->aadhar_card_image)
                            <span class="doc-status status-verified">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @else
                            <span class="doc-status status-missing">
                                <i class="fas fa-exclamation-triangle"></i> Missing
                            </span>
                        @endif

                        <div class="doc-preview">
                            @if ($document->aadhar_card_image)
                                <img src="{{ route('document.image', ['type' => 'aadhaar', 'filename' => $document->aadhar_card_image]) }}"
                                    alt="Aadhaar Card Preview">
                            @else
                                <i class="fas fa-id-card doc-icon"></i>
                            @endif
                        </div>

                        <div class="doc-content">
                            <h3 class="doc-title">Aadhaar Card</h3>
                            <p class="doc-info">
                                @if ($document->aadhar_card_number)
                                    Identity Number: XXXX-XXXX-{{ substr($document->aadhar_card_number, -4) }}
                                @else
                                    Required for primary KYC verification.
                                @endif
                            </p>

                            @if ($document->aadhar_card_image)
                                <a href="{{ route('my-documents.show', 'aadhaar') }}" class="custom-btn">
                                    <i class="fas fa-file-alt"></i>
                                    View Document
                                </a>
                            @else
                                <a href="{{ route('enter-aadhaar') }}" class="custom-btn btn-upload-missing">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Upload & Verify
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- PAN Card -->
                    <div class="doc-card">
                        @if ($document->pan_card_image)
                            <span class="doc-status status-verified">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @else
                            <span class="doc-status status-missing">
                                <i class="fas fa-exclamation-triangle"></i> Missing
                            </span>
                        @endif

                        <div class="doc-preview">
                            @if ($document->pan_card_image)
                                <img src="{{ route('document.image', ['type' => 'pan', 'filename' => $document->pan_card_image]) }}"
                                    alt="PAN Card Preview">
                            @else
                                <i class="fas fa-address-card doc-icon"></i>
                            @endif
                        </div>

                        <div class="doc-content">
                            <h3 class="doc-title">PAN Card</h3>
                            <p class="doc-info">
                                @if ($document->pan_card_number)
                                    Tax ID:
                                    {{ substr($document->pan_card_number, 0, 2) }}XXXXXX{{ substr($document->pan_card_number, -2) }}
                                @else
                                    Required for all financial transactions.
                                @endif
                            </p>

                            @if ($document->pan_card_image)
                                <a href="{{ route('my-documents.show', 'pan') }}" class="custom-btn btn-view-primary">
                                    <i class="fas fa-file-alt"></i>
                                    View Document
                                </a>
                            @else
                                <a href="{{ route('pan') }}" class="custom-btn btn-upload-missing">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Upload & Verify
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Credit Report -->
                    <div class="doc-card">
                        <span class="doc-status status-pending">
                            <i class="fas fa-check-circle"></i> Generated
                        </span>

                        <div class="doc-preview">
                            <i class="fas fa-chart-bar doc-icon"></i>
                        </div>

                        <div class="doc-content">
                            <h3 class="doc-title">Credit Report (CIBIL)</h3>
                            <p class="doc-info">
                                Latest Score:
                                <strong style="color: #48bb78;">{{ $document->cibil_score ?? 'N/A' }}</strong>
                            </p>

                            <a href="{{ route('cibil_credit_score') }}" class="custom-btn btn-view-primary">
                                <i class="fas fa-file-invoice-dollar"></i>
                                Analyze Report
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No Documents Found</h3>
                    <p>We couldn't find any documents linked to your account. Start by uploading your primary KYC documents.
                    </p>
                    <a href="{{ route('enter-aadhaar') }}" class="custom-btn"
                        style="width: max-content;
    margin: 0 auto;">
                        <i class="fas fa-upload me-2"></i>
                        Start Verification
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
