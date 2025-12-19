@extends('layouts.app')

@section('title', 'Home - AI Loan Portal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

@endsection

@section('content')

    <div class="carousel-wrapper">
        <div class="container">
            <div class="swiper heroSwiper">

                <!-- Slides -->
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="slide">
                            <div class="slide-content">
                                <h1>Personal Loans Starting at 9.99% APR</h1>
                                <p>
                                    Flexible repayment options, no hidden charges, and transparent terms.
                                    Borrow up to ₹100,000 for any personal expense with minimal paperwork.
                                </p>
                                <div class="slide-buttons">
                                    <a href="#" class="btn">24 Hours<span>Quick Disbursal</span></a>
                                    <a href="#" class="btn">₹100K<span>Max Loan Amount</span></a>
                                </div>
                            </div>
                            <img src="{{ asset('images/hero-img.png') }}" alt="Hero Image" class="img-fluid">
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="slide">
                            <div class="slide-content">
                                <h1>Trusted by Millions of Users Worldwide</h1>
                                <p>
                                    Become a part of our expanding global community and unlock a range of exclusive
                                    benefits! Experience seamless, fast, and reliable services designed to enhance your
                                    experience.
                                </p>
                                <div class="slide-buttons">
                                    <a href="#" class="btn">24 Hours<span>Quick Disbursal</span></a>
                                    <a href="#" class="btn">₹100K<span>Max Loan Amount</span></a>
                                </div>
                            </div>
                            <img src="{{ asset('images/hero-img.png') }}" alt="Hero Image" class="img-fluid">
                        </div>
                    </div>

                </div>
                <!-- Pagination (optional) -->
                {{-- <div class="swiper-pagination"></div> --}}

            </div>
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <section class="features-wrapper section-padding">
        <div class="container">
            <div class="feature-card">
                <div class="card-info">
                    <div class="card-icon blue"><i class="bi bi-calendar4"></i></div>
                    <h3>Free CIBIL Score</h3>
                    <p>Get your latest credit report instantly and understand your financial health.</p>
                    <a href="{{ route('enter-aadhaar') }}" class="card-link">Check Now →</a>
                </div>

                <div class="card-info">
                    <div class="card-icon green"><i class="bi bi-card-list"></i></div>
                    <h3>Loan Eligibility</h3>
                    <p>Find out how much you can borrow in just 2 minutes with our simple checker.</p>
                    <a href="#" class="card-link">Calculate Now →</a>
                </div>

                <div class="card-info">
                    <div class="card-icon purple"><i class="bi bi-person"></i></div>
                    <h3>Create Account</h3>
                    <p>Join us to unlock personalized offers and manage your applications with ease.</p>
                    <a href="{{ route('register.create') }}" class="card-link">Sign Up Today →</a>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works section-padding">
        <div class="container">
            <h2>How It Works</h2>
            <p class="subtitle">Get your loan approved in just 3 simple steps</p>

            <div class="steps">
                <!-- Step 1 -->
                <div class="step">
                    <span class="step-number">1</span>
                    <div class="icon blue">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h4>Apply Online</h4>
                    <p>
                        Fill out our simple online application form with basic details.
                        No paperwork required at this stage.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="step">
                    <span class="step-number">2</span>
                    <div class="icon green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4>Get Approved</h4>
                    <p>
                        Our AI-powered system instantly verifies your details and
                        provides approval within 2 minutes.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="step">
                    <span class="step-number">3</span>
                    <div class="icon purple">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h4>Receive Funds</h4>
                    <p>
                        Once approved, funds will be transferred directly to your
                        bank account within 24 hours.
                    </p>
                </div>
            </div>

            <div class="cta">
                <a href="#" class="btn-primary">Start Your Application</a>
            </div>
        </div>
    </section>

    <footer class="footer section-padding">
        <div class="container">
            <!-- Top -->
            <div class="footer-top">
                <h2 class="logo">LoanPortal</h2>
                <p class="tagline">
                    Your trusted partner for all loan needs. Fast, secure, and transparent.
                </p>
            </div>

            <hr class="divider">

            <!-- Bottom -->
            <div class="footer-bottom">
                <div class="footer-left">
                    © 2025 LoanPortal. All rights reserved.
                </div>

                <div class="footer-center">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                </div>

                <div class="footer-right">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>

        </div>
    </footer>

@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endpush
