@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@endsection

{{-- @section('body-class', 'dashboard') --}}

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
                    {{-- <div class="profile">
                <img src="https://i.pravatar.cc/40" alt="User">
                <span class="user-name">{{ $userName }}</span>
            </div> --}}
                    <div class="profile-dropdown">
                        <div class="profile-toggle">
                            <img src="https://i.pravatar.cc/40" alt="User">
                            <span class="user-name">{{ $userName }}</span>
                            <i class="fas fa-caret-down"></i>
                        </div>
                        <div class="profile-menu">
                            <a href="#">Setting</a>
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

    <div class="hero-section">
        <div class="container">
            <div class="hero-grid">
                <!-- Left Content -->
                <div class="hero-content">
                    <div class="text-center">
                        <p class="trust-text">Trusted by 50,000+ customers</p>
                    </div>
                    <h1 class="hero-title">
                        Find Your Perfect<br>
                        <span class="hero-title-accent">Loan Solution</span>
                    </h1>

                    <p class="hero-description">
                        Compare rates, calculate payments, and get approved faster. From home loans to business financing,
                        we've got you covered.
                    </p>

                    <div class="hero-buttons">
                        <button class="btn btn-primary">
                            Explore Loans
                        </button>
                        <button class="btn btn-secondary">
                            📊 Calculate EMI
                        </button>
                    </div>

                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-value">3.5%</div>
                            <div class="stat-label">Interest rate</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">24hrs</div>
                            <div class="stat-label">Quick Approval</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">₹5M+</div>
                            <div class="stat-label">Loan Disbursed</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Estimate Calculator -->
                <div class="calculator-card">
                    <div class="calculator-header">
                        <h3>Quick Estimate</h3>
                        <button class="icon-btn">📊</button>
                    </div>

                    <div class="form-group">
                        <label>Loan Amount</label>
                        <input type="number" id="loanAmount" value="50000" class="form-input">
                    </div>

                    <div class="form-group">
                        <label>Loan Term</label>
                        <select id="loanTerm" class="form-input">
                            <option value="12">12 months</option>
                            <option value="24">24 months</option>
                            <option value="36">36 months</option>
                            <option value="48">48 months</option>
                        </select>
                    </div>

                    <div class="payment-display">
                        <div class="payment-label">Monthly Payment</div>
                        <div class="payment-value" id="monthlyPayment">₹4,350</div>
                    </div>

                    <button class="btn btn-dark btn-full">
                        Apply Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="container">
            <header class="dashboard-header">
                <h2>Welcome back, {{ $userName }}!</h2>
                <p>Here's an overview of your financial dashboard</p>
            </header>

            <div class="main-actions-grid">
                <div class="action-card card-green">
                    <div class="icon-box"><i class="fas fa-file-invoice"></i></div>
                    <h3 class="card-title">Apply for Loan</h3>
                    <p class="card-description">Start your loan application process with our simple and quick form. Get
                        approved
                        in minutes.</p>
                    <a href="{{ route('apply_loan') }}" class="btn btn-card-action">Start Application &rarr;</a>
                </div>

                <div class="action-card card-blue-light">
                    <div class="icon-box"><i class="fas fa-robot"></i></div>
                    <h3 class="card-title">AI Eligibility Checker</h3>
                    <p class="card-description">Use our AI-powered tool to instantly check your loan eligibility and get
                        personalized recommendations.</p>
                    <a href="#" class="btn btn-card-action">Check Eligibility &rarr;</a>
                </div>

                <div class="action-card card-blue-dark">
                    <div class="icon-box"><i class="fas fa-bell"></i></div>
                    <h3 class="card-title">Loan Updates</h3>
                    <p class="card-description">Stay informed about your loan status, payment schedules, and important
                        notifications.</p>
                    <a href="#" class="btn btn-card-action">View Updates &rarr;</a>
                </div>

                <div class="action-card card-orange">
                    <div class="icon-box"><i class="fas fa-chart-line"></i></div>
                    <h3 class="card-title">Other Loan Tracking</h3>
                    <p class="card-description">Track all your external loans and manage multiple financial obligations in
                        one
                        place.</p>
                    <a href="#" class="btn btn-card-action">Track Loans &rarr;</a>
                </div>

            </div>

            <div class="quick-actions-section">
                <h5 class="fw-semibold mb-3 quick-actions-title">Quick Actions</h5>
                <div class="quick-actions-list">
                    <a href="{{ route('enter-aadhaar') }}" class="quick-item-button">
                        <i class="fas fa-plus"></i>
                        <p class="mb-0 fw-medium">Free CIBIL Score</p>
                    </a>
                    <a href="{{ route('my-documents') }}" class="quick-item-button my-doc">
                        <i class="fas fa-folder"></i>
                        <p class="mb-0 fw-medium">My Document Locker</p>
                    </a>
                     <a href="#" class="quick-item-button">
                        <i class="fas fa-headset"></i>
                        <p class="mb-0 fw-medium">Customer Support</p>
                    </a>
                    <a href="#" class="quick-item-button">
                        <i class="fas fa-calculator"></i>
                        <p class="mb-0 fw-medium">EMI Calculator</p>
                    </a>
                    <a href="#" class="quick-item-button">
                        <i class="fas fa-headset"></i>
                        <p class="mb-0 fw-medium">Services Support</p>
                    </a>
                </div>
                </section>
            </div>
        </div>

    @endsection
    @push('scripts')
        {{-- <script src="{{ asset('js/register.js') }}"></script> --}}
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
            <script>
        // EMI Calculator
        function calculateEMI() {
            const amount = parseFloat(document.getElementById('loanAmount').value);
            const months = parseInt(document.getElementById('loanTerm').value);
            const rate = 0.035; // 3.5% annual rate
            const monthlyRate = rate / 12;

            const payment = amount * (monthlyRate * Math.pow(1 + monthlyRate, months)) / (Math.pow(1 + monthlyRate,
                months) - 1);

            document.getElementById('monthlyPayment').textContent = '₹' + Math.round(payment).toLocaleString();
        }

        // Add event listeners
        document.getElementById('loanAmount').addEventListener('input', calculateEMI);
        document.getElementById('loanTerm').addEventListener('change', calculateEMI);

        // Initial calculation
        calculateEMI();


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
