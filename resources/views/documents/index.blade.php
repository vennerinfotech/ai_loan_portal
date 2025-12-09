@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* --- General Layout & Header Styles (Retained) --- */
        .locker-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        .locker-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .user-meta {
            display: flex;
            gap: 20px;
            margin-top: 10px;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .meta-item {
            background: rgba(255,255,255,0.1);
            padding: 5px 15px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* --- Redesigned Document Grid and Card Styles --- */
        
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px; /* Increased gap for better breathing room */
        }

        .doc-card {
            background: #ffffff; /* White background */
            border-radius: 18px; /* Slightly larger border-radius for a modern look */
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08); /* Stronger but softer shadow */
            border: 1px solid #e2e8f0; /* Light border for definition */
            position: relative;
            display: flex; 
            flex-direction: column;
        }

        .doc-card:hover {
            transform: translateY(-8px); /* More pronounced lift on hover */
            box-shadow: 0 20px 40px rgba(0,0,0,0.15); /* Premium hover shadow */
            border-color: #3182ce; /* Highlight border on hover (Primary Blue) */
        }

        .doc-preview {
            height: 180px;
            /* Use a very light, subtle gradient background */
            background: linear-gradient(145deg, #f7f9fb 0%, #edf2f7 100%); 
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem;
        }

        .doc-icon {
            font-size: 4.5rem; /* Slightly larger icon */
            color: #a0aec0; /* A darker, more grounded grey */
            opacity: 0.7;
        }

        /* Enhancing the Status Badge */
        .doc-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 14px; /* Slightly more padding */
            border-radius: 5px; /* Square off the corners slightly for a modern badge look */
            font-size: 0.75rem; /* Smaller, punchier text */
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Using your original colors for status but improving contrast/look */
        .status-verified {
            background: #48bb78; /* Original Success Green */
            color: white; 
        }

        .status-pending {
            background: #f6ad55; /* Original Warning Yellow/Orange */
            color: #5f370e; 
        }

        .status-missing {
            background: #f56565; /* Original Danger Red */
            color: white; 
        }

        .doc-content {
            padding: 2rem 1.5rem; /* More vertical padding */
            flex-grow: 1; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .doc-title {
            font-size: 1.3rem; /* Larger, more dominant title */
            font-weight: 700;
            margin-bottom: 0.3rem;
            color: #2d3748;
        }

        .doc-info {
            font-size: 0.85rem; 
            color: #718096;
            margin-bottom: 2rem;
            min-height: 2.5rem; /* Ensures consistent card height */
        }

        .btn-view {
            display: block;
            width: 100%;
            padding: 12px; /* Taller button */
            text-align: center;
            background: #3182ce; /* Primary Blue */
            color: white;
            border-radius: 10px; 
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.1s ease;
            box-shadow: 0 4px 10px rgba(49, 130, 206, 0.3); 
        }

        .btn-view:hover {
            background: #2b6cb0; /* Darker blue */
            transform: translateY(-2px); 
            color: white;
        }

        /* Specific Upload Button Style for Missing Docs (Red for urgency) */
        .btn-upload-missing {
            background-color: #e53e3e !important; 
            box-shadow: 0 4px 10px rgba(229, 62, 62, 0.3);
        }

        .btn-upload-missing:hover {
            background-color: #c53030 !important;
        }

        .empty-state {
            text-align: center;
            padding: 4rem;
            background: white;
            border-radius: 15px;
            color: #718096;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
@endsection

@section('content')
<div class="locker-container">
    <div class="locker-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2"><i class="fas fa-vault me-2"></i>My Document Locker</h1>
                <p class="mb-0">Secure storage for your verified financial documents</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm text-primary">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
        
        <div class="user-meta mt-4">
            <span class="meta-item">
                <i class="fas fa-user-circle"></i> {{ $user->name }}
            </span>
            <span class="meta-item">
                <i class="fas fa-id-badge"></i> User ID: {{ $user->id }}
            </span>
            @if(isset($document) && $document)
                <span class="meta-item">
                    <i class="fas fa-file-contract"></i> Doc Ref: {{ $document->customer_id ?? 'N/A' }}
                </span>
            @endif
        </div>
    </div>

    @if(isset($document) && $document)
    <div class="documents-grid">
        <div class="doc-card">
            <div class="doc-preview">
                @if($document->aadhar_card_image)
                    {{-- Display image if available, set opacity for the preview effect --}}
                    <img src="{{ route('document.image', ['type' => 'aadhaar', 'filename' => $document->aadhar_card_image]) }}" 
                         alt="Aadhaar Card Preview" 
                         style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
                    <span class="doc-status status-verified"><i class="fas fa-check-circle me-1"></i> Verified</span>
                @else
                    {{-- Default icon for missing document --}}
                    <i class="fas fa-id-card doc-icon"></i>
                    <span class="doc-status status-missing"><i class="fas fa-exclamation-triangle me-1"></i> Missing</span>
                @endif
            </div>
            <div class="doc-content">
                <div>
                    <h3 class="doc-title">Aadhaar Card</h3>
                    <p class="doc-info">
                        @if($document->aadhar_card_number)
                            Identity Number: XXXX-XXXX-{{ substr($document->aadhar_card_number, -4) }}
                        @else
                            Required for primary KYC verification.
                        @endif
                    </p>
                </div>
                
                @if($document->aadhar_card_image)
                    <a href="{{ route('my-documents.show', 'aadhaar') }}" class="btn-view">
                        <i class="fas fa-file-alt me-1"></i> View Document
                    </a>
                @else
                    <a href="{{ route('enter-aadhaar') }}" class="btn-view btn-upload-missing">
                        <i class="fas fa-cloud-upload-alt me-1"></i> Upload & Verify
                    </a>
                @endif
            </div>
        </div>

        <div class="doc-card">
            <div class="doc-preview">
                @if($document->pan_card_image)
                    <img src="{{ route('document.image', ['type' => 'pan', 'filename' => $document->pan_card_image]) }}" 
                         alt="PAN Card Preview" 
                         style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
                    <span class="doc-status status-verified"><i class="fas fa-check-circle me-1"></i> Verified</span>
                @else
                    <i class="fas fa-address-card doc-icon"></i>
                    <span class="doc-status status-missing"><i class="fas fa-exclamation-triangle me-1"></i> Missing</span>
                @endif
            </div>
            <div class="doc-content">
                <div>
                    <h3 class="doc-title">PAN Card</h3>
                    <p class="doc-info">
                        @if($document->pan_card_number)
                            Tax ID: {{ substr($document->pan_card_number, 0, 2) }}XXXXXX{{ substr($document->pan_card_number, -2) }}
                        @else
                            Required for all financial transactions.
                        @endif
                    </p>
                </div>
                
                @if($document->pan_card_image)
                    <a href="{{ route('my-documents.show', 'pan') }}" class="btn-view">
                        <i class="fas fa-file-alt me-1"></i> View Document
                    </a>
                @else
                    <a href="{{ route('pan') }}" class="btn-view btn-upload-missing">
                        <i class="fas fa-cloud-upload-alt me-1"></i> Upload & Verify
                    </a>
                @endif
            </div>
        </div>
        
        <div class="doc-card">
            <div class="doc-preview">
                 <i class="fas fa-chart-bar doc-icon"></i>
                 <span class="doc-status status-pending"><i class="fas fa-clock me-1"></i> Generated</span>
            </div>
            <div class="doc-content">
                <div>
                    <h3 class="doc-title">Credit Report (CIBIL)</h3>
                    <p class="doc-info">
                        Latest Score: 
                        <span class="fw-bold text-success">{{ $document->cibil_score ?? 'N/A' }}</span>
                    </p>
                </div>
                <a href="{{ route('cibil_credit_score') }}" class="btn-view">
                    <i class="fas fa-file-invoice-dollar me-1"></i> Analyze Report
                </a>
            </div>
        </div>

    </div>
    @else
        <div class="empty-state">
            <i class="fas fa-folder-open mb-4" style="font-size: 4rem; color: #cbd5e0;"></i>
            <h3>No Documents Found</h3>
            <p>We couldn't find any documents linked to your account. Start by uploading your primary KYC documents.</p>
            <a href="{{ route('enter-aadhaar') }}" class="btn btn-primary mt-3">Start Verification</a>
        </div>
    @endif
</div>
@endsection