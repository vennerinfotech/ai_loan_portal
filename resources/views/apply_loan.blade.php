@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/apply_loan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common_header.css') }}">
@endsection

@section('content')
@include('layouts.common_header')

    <section class="banner-wrapper">
        <div class="banner-image">
            <img src="../images/apply_loan.jpg" alt="Loan Banner" class="img-fluid">
        </div>
    </section>

    <!-- Loan Types Section -->
    <div class="loan-types-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Choose Your Loan Type</h2>
                <p class="section-description">
                    Flexible financing options tailored to your needs
                </p>
            </div>

            <div class="loan-grid">
                <!-- Home Loan -->
                <div class="loan-card">
                    <div class="loan-icon icon-blue">
                        <i class="fa-solid fa-home"></i>
                    </div>
                    <h3 class="loan-title">Home Loan</h3>
                    <p class="loan-description">Make your dream home a reality with competitive rates starting from 3.5% and
                        flexible repayment</p>
                    <ul class="loan-features">
                        <li><span class="check">✓</span> Up to ₹1,00,00,000</li>
                        <li><span class="check">✓</span> 30-year terms available</li>
                        <li><span class="check">✓</span> Low down payment</li>
                    </ul>
                    <a href="{{ route('input_loan_amount') }}" target="_blank" class="btn btn-blue btn-full">Learn More</a>
                </div>

                <!-- Personal Loan -->
                <div class="loan-card">
                    <div class="loan-icon icon-purple">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h3 class="loan-title">Personal Loan</h3>
                    <p class="loan-description">Quick funding for your personal needs. No collateral required with rates
                        starting from 8.5%</p>
                    <ul class="loan-features">
                        <li><span class="check">✓</span> Up to ₹10,00,000</li>
                        <li><span class="check">✓</span> Same day approval</li>
                        <li><span class="check">✓</span> Flexible use of funds</li>
                    </ul>
                    <a href="{{ route('input_loan_amount') }}" target="_blank" class="btn btn-purple btn-full">Learn More</a>
                </div>

                <!-- Business Loan -->
                <div class="loan-card">
                    <div class="loan-icon icon-green">
                        <i class="fa-solid fa-business-time"></i>
                    </div>
                    <h3 class="loan-title">Business Loan</h3>
                    <p class="loan-description">Fuel your business growth with tailored financing solutions and competitive
                        rates starting from 7%</p>
                    <ul class="loan-features">
                        <li><span class="check">✓</span> Up to ₹5,00,00,000</li>
                        <li><span class="check">✓</span> Working capital support</li>
                        <li><span class="check">✓</span> Dedicated support</li>
                    </ul>
                    <a href="{{ route('input_loan_amount') }}" target="_blank" class="btn btn-green btn-full">Learn More</a>
                </div>

                <!-- Mortgage Loan -->
                <div class="loan-card">
                    <div class="loan-icon icon-orange">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <h3 class="loan-title">Mortgage Loan</h3>
                    <p class="loan-description">Refinance or purchase property with our comprehensive mortgage solutions at
                        best rates</p>
                    <ul class="loan-features">
                        <li><span class="check">✓</span> Fixed & variable rates</li>
                        <li><span class="check">✓</span> Pre-approval available</li>
                        <li><span class="check">✓</span> Expert guidance</li>
                    </ul>
                    <a href="{{ route('input_loan_amount') }}" target="_blank" class="btn btn-orange btn-full">Learn More</a>
                </div>

                <!-- Car Loan -->
                <div class="loan-card">
                    <div class="loan-icon icon-red">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <h3 class="loan-title">Car Loan</h3>
                    <p class="loan-description">Drive away in your dream car with affordable financing options and deals
                        starting from 6.5%</p>
                    <ul class="loan-features">
                        <li><span class="check">✓</span> Up to ₹15,00,000</li>
                        <li><span class="check">✓</span> New & used vehicles</li>
                        <li><span class="check">✓</span> Fast processing</li>
                    </ul>
                    <a href="{{ route('input_loan_amount') }}" target="_blank" class="btn btn-red btn-full">Learn More</a>
                </div>

                <!-- Other Loan -->
                <div class="loan-card">
                    <div class="loan-icon icon-pink">
                        <i class="fa-solid fa-pen-nib"></i>
                    </div>
                    <h3 class="loan-title">Other Loan</h3>
                    <p class="loan-description">Custom loan solutions for education, medical, travel, and other unique
                        financing needs</p>
                    <ul class="loan-features">
                        <li><span class="check">✓</span> Customized terms</li>
                        <li><span class="check">✓</span> Multiple purposes</li>
                        <li><span class="check">✓</span> Personalized rates</li>
                    </ul>
                    <a href="{{ route('input_loan_amount') }}" target="_blank" class="btn btn-pink btn-full">Learn
                        More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Section -->
    <div class="why-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why Choose LoanHub?</h2>
                <p class="section-description">
                    Experience hassle-free lending with industry-leading benefits
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Quick Approval</h3>
                    <p class="feature-description">Get approved in as little as 24 hours</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">🛡️</div>
                    <h3 class="feature-title">100% Secure</h3>
                    <p class="feature-description">Industry-leading security of data</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">📉</div>
                    <h3 class="feature-title">Best Rates</h3>
                    <p class="feature-description">Competitive interest rates guaranteed</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">🎧</div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="feature-description">Expert assistance anytime you need</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
