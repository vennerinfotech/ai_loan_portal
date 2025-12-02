@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('body-class', 'dashboard')

@section('content')
<header class="main-header">
    <h2 class="logo-text">LoanHub</h2>
    <div class="header-right">
        <div class="notification">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
            </svg>
            <span class="dot"></span>
        </div>
        <div class="profile">
            <img src="https://i.pravatar.cc/40" alt="User">
            <span class="user-name">John Doe</span>
        </div>
    </div>
</header>

<div class="dashboard-container">
    <header class="dashboard-header">
        <h2>Welcome back, John!</h2>
        <p>Here's an overview of your financial dashboard</p>
    </header>

    <div class="main-actions-grid">

        <div class="action-card card-green">
            <div class="icon-box"><i class="fas fa-file-invoice"></i></div>
            <h3 class="card-title">Apply for Loan</h3>
            <p class="card-description">Start your loan application process with our simple and quick form. Get approved
                in minutes.</p>
            <a href="#" class="btn btn-card-action">Start Application &rarr;</a>
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
            <p class="card-description">Track all your external loans and manage multiple financial obligations in one
                place.</p>
            <a href="#" class="btn btn-card-action">Track Loans &rarr;</a>
        </div>

    </div>

    <section class="quick-actions-section">
        <h5 class="fw-semibold mb-3 quick-actions-title">Quick Actions</h5>
        <div class="quick-actions-list">
            <a href="#" class="quick-item-button">
                <i class="fas fa-plus"></i>
                <p class="mb-0 fw-medium">Free CIBIL Score</p>
            </a>
            <a href="#" class="quick-item-button my-doc">
                <i class="fas fa-folder"></i>
                <p class="mb-0 fw-medium">My Document Locker</p>
            </a>
            <a href="#" class="quick-item-button">
                <i class="fas fa-calculator"></i>
                <p class="mb-0 fw-medium">EMI Calculator</p>
            </a>
            <a href="#" class="quick-item-button">
                <i class="fas fa-headset"></i>
                <p class="mb-0 fw-medium">Customer Support</p>
            </a>
            <a href="#" class="quick-item-button">
                <i class="fas fa-headset"></i>
                <p class="mb-0 fw-medium">Services Support</p>
            </a>
        </div>
    </section>

</div>
@endsection
