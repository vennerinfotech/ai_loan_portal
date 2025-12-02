@extends('layouts.app')

@section('title', 'Home - AI Loan Portal')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('body-class', 'carousel')

@section('content')
<div class="carousel">
    <button class="carousel-btn left" onclick="prevSlide()">
        <i class="bi bi-chevron-left"></i>
    </button>

    <div class="slides" id="slides">
        <!-- Slide 1 -->
        <div class="slide">
            <div class="slide-content">
                <h1>Fast, Secure & <br> Transparent Loans.</h1>
                <p>Experience a seamless borrowing journey with our customer-first approach.</p>
                <div class="slide-buttons">
                    <a href="#" class="btns primary">Apply Now</a>
                    <a href="#" class="btns secondary">Learn More →</a>
                </div>
            </div>
            <img src="{{ asset('images/hero-img.png') }}" alt="Hero Image">
        </div>
        <!-- Slide 2 -->
        <div class="slide">
            <div class="slide-content">
                <h1>Quick Approvals <br> Low Interest Rates.</h1>
                <p>Get instant approval with minimal documentation. Designed for your convenience.</p>
                <div class="slide-buttons">
                    <a href="#" class="btns primary">Apply Now</a>
                    <a href="#" class="btns secondary">Learn More →</a>
                </div>
            </div>
            <img src="images/hero-img.png" alt="Hero Image">
        </div>

        <!-- Slide 3 -->
        <div class="slide">
            <div class="slide-content">
                <h1>Trusted by <br> Millions of Users.</h1>
                <p>Join our growing community, enjoy exclusive benefits and fast services.</p>
                <div class="slide-buttons">
                    <a href="#" class="btns primary">Apply Now</a>
                    <a href="#" class="btns secondary">Learn More →</a>
                </div>
            </div>
            <img src="images/hero-img.png" alt="Hero Image">
        </div>
    </div>

    <button class="carousel-btn right" onclick="nextSlide()">
        <i class="bi bi-chevron-right"></i>
    </button>
</div>

<section class="features">
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
        <a href="{{ route('register') }}" class="card-link">Sign Up Today →</a>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endpush
