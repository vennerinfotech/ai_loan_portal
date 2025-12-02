@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/loan_offers.css') }}">
@endsection

@section('body-class', 'loan_offers')

@section('content')

<header class="main-header">
    <h2 class="logo-text">LoanHub</h2>
    <div class="header-right">
        <div class="notification">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5
                                                 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7
                                                 0-2.42-1.72-4.44-4.005-4.901" />
            </svg>
            <span class="dot"></span>
        </div>
        <div class="profile">
            <img src="https://i.pravatar.cc/40" alt="User">
            <span class="user-name">John Doe</span>
        </div>
    </div>
</header>

<div class="row g-4">


    <!-- Main Content -->
    <main class="container py-5 mt-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6 mb-3">Loan Offers Tailored For You</h2>
            <p class="text-muted fs-5">
                Choose from our exclusive loan offers with competitive rates and flexible terms
            </p>
        </div>
        <div class="loan_offers-container">
            <div class="row g-4">
                <!-- Personal Loan -->
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card bg-white p-4 shadow-sm h-100">
                        <div class="d-flex align-items-start mb-4 gap-3">
                            {{-- <div class="icon-box bg-success-subtle"> --}}
                            <i class="bi bi-person fs-4 text-success"></i>
                            {{--
                                </div> --}}
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Personal Loan</h5>
                                <span class="text-success fw-semibold small"><img src="{{ asset('images/i (5).png') }}" alt="Vector Logo"> Pre-approved</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Loan Amount</span>
                                <span class="loan-amount">₹5,00,000</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Interest Rate</span>
                                <span class="interest-rate">12% APR</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tenure</span>
                                <span class="fw-medium text-dark">Up to 5 years</span>
                            </div>
                        </div>

                        <button class="apply-btn" onclick="window.location.href='{{ route('enter-aadhaar') }}'">
                            Apply Now <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Home Loan -->
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card bg-white p-4 shadow-sm h-100">
                        <div class="d-flex align-items-start mb-4 gap-3">
                            {{-- <div class="icon-box bg-primary-subtle"> --}}
                            <i class="bi bi-house-door fs-4 text-primary"></i>
                            {{--
                                </div> --}}
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Home Loan</h5>
                                <span class="text-primary fw-semibold small"><img src="{{ asset('images/i (6).png') }}" alt="Vector Logo"> Apply Fresh</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Loan Amount</span>
                                <span class="loan-amount">₹50,00,000</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Interest Rate</span>
                                <span class="interest-rate">8.5% APR</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tenure</span>
                                <span class="fw-medium text-dark">Up to 30 years</span>
                            </div>
                        </div>

                        <button class="apply-btn" onclick="window.location.href='{{ route('enter-aadhaar') }}'">
                            Apply Now <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Car Loan -->
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card bg-white p-4 shadow-sm h-100">
                        <div class="d-flex align-items-start mb-4 gap-3">
                            {{-- <div class="icon-box bg-light"> --}}
                            <i class="bi bi-car-front fs-4 text-danger"></i>
                            {{--
                                </div> --}}
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Car Loan</h5>
                                <span class="text-danger fw-semibold small"><img src="{{ asset('images/i (7).png') }}" alt="Vector Logo"> Limited Time</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Loan Amount</span>
                                <span class="loan-amount">₹15,00,000</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Interest Rate</span>
                                <span class="interest-rate">9.5% APR</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tenure</span>
                                <span class="fw-medium text-dark">Up to 7 years</span>
                            </div>
                        </div>

                        <button class="apply-btn" onclick="window.location.href='{{ route('enter-aadhaar') }}'">
                            Apply Now <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Business Loan -->
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card bg-white p-4 shadow-sm h-100">
                        <div class="d-flex align-items-start mb-4 gap-3">
                            {{-- <div class="icon-box bg-success-subtle"> --}}
                            <i class="bi bi-briefcase fs-4 text-success"></i>
                            {{--
                                </div> --}}
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Business Loan</h5>
                                <span class="text-success fw-semibold small"><img src="{{ asset('images/i (8).png') }}" alt="Vector Logo"> Pre-approved</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Loan Amount</span>
                                <span class="loan-amount">₹25,00,000</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Interest Rate</span>
                                <span class="interest-rate">11% APR</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tenure</span>
                                <span class="fw-medium text-dark">Up to 10 years</span>
                            </div>
                        </div>

                        <button class="apply-btn" onclick="window.location.href='{{ route('enter-aadhaar') }}'">
                            Apply Now <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Education Loan -->
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card bg-white p-4 shadow-sm h-100">
                        <div class="d-flex align-items-start mb-4 gap-3">
                            {{-- <div class="icon-box bg-primary-subtle"> --}}
                            <i class="bi bi-mortarboard fs-4 text-primary"></i>
                            {{--
                                </div> --}}
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Education Loan</h5>
                                <span class="text-primary fw-semibold small"><img src="{{ asset('images/i (6).png') }}" alt="Vector Logo"> Apply Now</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Loan Amount</span>
                                <span class="loan-amount">₹20,00,000</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Interest Rate</span>
                                <span class="interest-rate">10% APR</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tenure</span>
                                <span class="fw-medium text-dark">Up to 15 years</span>
                            </div>
                        </div>

                        <button class="apply-btn" onclick="window.location.href='{{ route('enter-aadhaar') }}'">
                            Apply Now <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Gold Loan -->
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card bg-white p-4 shadow-sm h-100">
                        <div class="d-flex align-items-start mb-4 gap-3">
                            {{-- <div class="icon-box bg-warning-subtle"> --}}
                            <i class="bi bi-coin fs-4 text-warning"></i>
                            {{--
                                </div> --}}
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Gold Loan</h5>
                                <span class="text-warning fw-semibold small"><img src="{{ asset('images/i (9).png') }}" alt="Vector Logo"> Instant Approval</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Loan Amount</span>
                                <span class="loan-amount">₹10,00,000</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Interest Rate</span>
                                <span class="interest-rate">7.5% APR</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tenure</span>
                                <span class="fw-medium text-dark">Up to 3 years</span>
                            </div>
                        </div>

                        <button class="apply-btn" onclick="window.location.href='{{ route('enter-aadhaar') }}'">
                            Apply Now <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>
@endsection
