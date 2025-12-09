@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .details-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .breadcrumb-nav {
            margin-top: 100px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
        
        .breadcrumb-nav a {
            color: #4a5568;
            text-decoration: none;
        }

        .breadcrumb-nav span {
            color: #a0aec0;
            margin: 0 10px;
        }

        .details-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        @media(min-width: 768px) {
            .details-card {
                flex-direction: row;
                height: 670px;
            }
        }

        .image-section {
            flex: 1;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border-right: 1px solid #eee;
        }

        .doc-image {
            max-width: 100%;
            max-height: 100%;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .doc-image:hover {
            transform: scale(1.02);
        }

        .info-section {
            flex: 1;
            padding: 3rem;
            overflow-y: auto;
        }

        .doc-header {
            margin-bottom: 2rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }

        .doc-title {
            font-size: 1.8rem;
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-verified { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }

        .info-grid {
            display: grid;
            gap: 1.5rem;
        }

        .info-item label {
            display: block;
            color: #718096;
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item p {
            color: #2d3748;
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0;
            word-break: break-all;
        }

        .actions {
            margin-top: 3rem;
            display: flex;
            gap: 15px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary-custom {
            background: #3182ce;
            color: white;
            border: none;
        }

        .btn-primary-custom:hover {
            background: #2c5282;
            color: white;
            transform: translateY(-2px);
        }

        .no-image-placeholder {
            text-align: center;
            color: #a0aec0;
        }

        @media print {
            /* Hide everything by default */
            body > * {
                display: none !important;
            }

            /* Only display the details card and its image section */
            .details-container, .details-card, .image-section {
                display: block !important;
                position: visible !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: 100% !important;
                border: none !important;
                box-shadow: none !important;
                visibility: visible !important;
            }

            /* Specifically target the image to be visible and full size */
            .image-section img {
                display: block !important;
                width: 100% !important;
                height: auto !important;
                max-height: 100vh !important;
                object-fit: contain !important;
                visibility: visible !important;
            }
            
            /* Re-hide specific elements that might be inside the containers we displayed */
            .breadcrumb-nav, .info-section, .locker-header, header.main-header, .sidebar, .no-image-placeholder {
                display: none !important;
            }
            
            /* Ensure the image section is the only thing taking up space */
            .image-section {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 9999;
                background: white;
                display: flex !important;
                align-items: center;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <header class="main-header">
        <h2 class="logo-text">LoanHub</h2>
        <div class="header-right">
            <div class="notification">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-bell-fill" viewBox="0 0 16 16">
                    <path
                        d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                </svg>
                <span class="dot"></span>
            </div>
            <div class="profile-dropdown">
                <div class="profile-toggle">
                    <img src="https://i.pravatar.cc/40" alt="User">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <i class="fas fa-caret-down"></i>
                </div>
                <div class="profile-menu">
                    <a href="#">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>

        </div>
    </header>

<div class="details-container">
    <div class="breadcrumb-nav">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>/</span>
        <a href="{{ route('my-documents') }}">My Document Locker</a>
        <span>/</span>
        <span class="text-dark">{{ $data['title'] }}</span>
    </div>

    <div class="details-card">
        <div class="image-section">
            @if(!empty($data['image']))
                <img src="{{ route('document.image', ['type' => $type, 'filename' => $data['image']]) }}" alt="{{ $data['title'] }}" class="doc-image">
            @else
                <div class="no-image-placeholder">
                    <i class="fas fa-eye-slash mb-3" style="font-size: 5rem;"></i>
                    <p>No document image available</p>
                </div>
            @endif
        </div>

        <div class="info-section">
            <div class="doc-header">
                <h1 class="doc-title">{{ $data['title'] }}</h1>
                <span class="status-badge {{ $data['status'] == 'Verified' ? 'status-verified' : 'status-pending' }}">
                    {{ $data['status'] }}
                </span>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <label>Document Number</label>
                    <p>
                        @if($data['number'])
                            {{ $data['number'] }}
                        @else
                            <span class="text-muted">Not Found</span>
                        @endif
                    </p>
                </div>

                <div class="info-item">
                    <label>Name on Document</label>
                    <p>{{ $document->customer_name ?? $user->name }}</p>
                </div>

                <div class="info-item">
                    <label>OTP Verified</label>
                    <p>
                        @if($data['otp_verified'] == 'Yes')
                            <span class="text-success"><i class="fas fa-check-circle me-1"></i> Yes</span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle me-1"></i> No</span>
                        @endif
                    </p>
                </div>

                <div class="info-item">
                    <label>Last Updated</label>
                    <p>{{ $data['updated_at']->format('d M, Y h:i A') }}</p>
                </div>
                
                <div class="info-item">
                     <label>Uploaded On</label>
                    <p>{{ $data['created_at']->format('d M, Y') }}</p>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('my-documents') }}" class="btn-action" style="background: #e2e8f0; color: #4a5568;">
                    Back
                </a>
                <button class="btn-action btn-primary-custom" onclick="window.print()">
                    <i class="fas fa-print me-2"></i> Print Details
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
