@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/applicant.css') }}">
@endsection

@section('content')
    <section class="header-wrapper">
        <div class="container">
            <header class="header-inner">
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
                            <span class="user-name"></span>
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
        </div>
    </section>

    <div class="container">
        <div class="applicant_detail_wrapper">
            <!-- Left Sidebar -->
            <aside class="sidebar">
                <div class="verification-card">
                    <h2 class="card-title">Verification Status</h2>

                    <div class="verification-item">
                        <div class="icon-wrapper aadhaar-icon">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div class="verification-info">
                            <h3>Aadhaar</h3>
                            <p>XXXX XXXX 2345</p>
                        </div>
                        <span class="badge verified">Verified</span>
                    </div>

                    <div class="verification-item">
                        <div class="icon-wrapper pan-icon">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div class="verification-info">
                            <h3>PAN Card</h3>
                            <p>BEFGH5678J</p>
                        </div>
                        <span class="badge verified">Verified</span>
                    </div>

                    <div class="verification-item">
                        <div class="icon-wrapper mobile-icon">
                         <i class="fa-solid fa-mobile"></i>
                        </div>
                        <div class="verification-info">
                            <h3>Mobile OTP</h3>
                            <p>+91 98765-XXXXX</p>
                        </div>
                        <span class="badge verified">Verified</span>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="main-content">
                <!-- Header -->
                <header class="right-side-record">
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h1>Details Retrieved Successfully</h1>
                            <p>Verified from government databases</p>
                        </div>
                    </div>
                    <div class="co-Applicant-btn">
                        <div class="dropdown">
                            <button class="btn btn-secondary">+ Co-Applicant</button>
                            <div class="dropdown-menu-custom">
                                <a href="{{ route('enter-aadhaar') }}">Co-Applicant 1</a>
                                <a href="{{ route('enter-aadhaar') }}">Co-Applicant 2</a>
                                <a href="{{ route('enter-aadhaar') }}">Co-Applicant 3</a>
                                <a href="{{ route('enter-aadhaar') }}">Co-Applicant 4</a>
                                <a href="{{ route('enter-aadhaar') }}">Co-Applicant 5</a>
                                <a href="{{ route('enter-aadhaar') }}">Guarantor</a>
                            </div>
                        </div>
                    </div>

                </header>

                <!-- Profile Section -->
                <section class="profile-section">
                    <img src="{{ asset('images/login-2.jpg') }}" alt="Profile" class="profile-image">
                    <div class="profile-info">
                        <h2>Ajay Sharma</h2>
                        <p class="profile-role">Co-Applicant</p>
                        <div class="profile-badges">
                            <span class="status-badge aadhaar-badge">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" fill="currentColor" />
                                    <path d="M8 12l2.5 2.5L16 9" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                Aadhaar Verified
                            </span>
                            <span class="status-badge pan-badge">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" fill="currentColor" />
                                    <path d="M8 12l2.5 2.5L16 9" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                PAN Verified
                            </span>
                        </div>
                    </div>
                </section>

                <!-- Information Grid -->
                <div class="info-grid">
                    <!-- Personal Information -->
                    <section class="info-card">
                        <h3 class="section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" />
                                <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" stroke="currentColor"
                                    stroke-width="2" />
                            </svg>
                            Personal Information
                        </h3>
                        <div class="info-row">
                            <div class="info-item">
                                <label>Full Name</label>
                                <p>Ajay Sharma</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item">
                                <label>Date of Birth</label>
                                <p>15 March 1992</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item">
                                <label>Gender</label>
                                <p>Male</p>
                            </div>
                        </div>
                        {{-- <div class="info-row">
                            <div class="info-item">
                                <label>Marital Status</label>
                                <p>Married</p>
                            </div>
                        </div> --}}
                    </section>

                    <!-- Contact Information -->
                    <section class="info-card">
                        <h3 class="section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"
                                    stroke="currentColor" stroke-width="2" />
                            </svg>
                            Contact Information
                        </h3>
                        <div class="info-row">
                            <div class="info-item">
                                <label>Mobile Number</label>
                                <p>+91 98765 43210</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item">
                                <label>Email Address</label>
                                <p>ajay.sharma@email.com</p>
                            </div>
                        </div>
                        {{-- <div class="info-row">
                            <div class="info-item">
                                <label>Alternate Number</label>
                                <p>+91 87654 32109</p>
                            </div>
                        </div> --}}
                    </section>
                </div>

                <!-- Address Details -->
                <section class="info-card address-card">
                    <h3 class="section-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor"
                                stroke-width="2" />
                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" />
                        </svg>
                        Address Details
                    </h3>
                    <div class="address-grid">
                        <div class="info-item">
                            <label>Address Line 1</label>
                            <p>45, MG Road, Koramangala</p>
                        </div>
                        <div class="info-item">
                            <label>Address Line 2</label>
                            <p>Near Metro Station</p>
                        </div>
                        <div class="info-item">
                            <label>City</label>
                            <p>Bangalore</p>
                        </div>
                        <div class="info-item">
                            <label>State</label>
                            <p>Karnataka</p>
                        </div>
                        <div class="info-item">
                            <label>PIN Code</label>
                            <p>560034</p>
                        </div>
                        <div class="info-item">
                            <label>Country</label>
                            <p>India</p>
                        </div>
                    </div>
                </section>
            </main>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileToggle = document.querySelector('.profile-toggle');
            const profileMenu = document.querySelector('.profile-menu');

            if (profileToggle) {
                profileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileMenu.classList.toggle('show');
                });

                document.addEventListener('click', function() {
                    profileMenu.classList.remove('show');
                });
            }
        });

    </script>
@endpush
