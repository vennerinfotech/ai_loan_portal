@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('body-class', 'bg-light')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg custom-card">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="LoanHub Logo" class="logo">
                    <h2 class="brand">LoanHub</h2>
                </div>
                <p class="text-center text-muted mb-4">Sign in to your account to continue</p>

                <button class="btn btn-outline-secondary w-100 mb-3 google-btn" type="button">
                    <i class="bi bi-google" id="google"></i>
                    Continue with Google
                </button>

                <p class="text-center text-muted my-3 divider-text">or continue with email</p>

                <form id="loginForm" action="{{ route('login.authenticate') }}" method="POST">
                    @csrf



                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <div class="input-group custom-input-group">
                            <span class="input-group-text custom-icon-bg"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control custom-input" id="email" name="email"
                                placeholder="Enter your email">
                        </div>
                    </div>
                    @error('email')
                        <div class="error-message text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group custom-input-group">
                            <span class="input-group-text custom-icon-bg"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control custom-input" id="password" name="mpin"
                                placeholder="Enter your password">
                            <span class="input-group-text custom-icon-bg password-toggle" id="togglePassword">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    @error('mpin')
                        <div class="error-message text-danger">{{ $message }}</div>
                    @enderror
                    <!-- Display session error message -->
                    @if (session('error'))
                        <div class="error-message text-danger mb-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                            <label class="form-check-label text-muted" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none forgot-password-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 sign-in-btn">
                        Sign in <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <p class="text-center mt-4">
                    Don't have an account? <a href="{{ route('register.create') }}"
                        class="text-decoration-none sign-up-link">Sign up for free</a>
                </p>
                <p class="text-center mt-3 text-muted need-help-text">Need help?</p>
                <p class="text-center">
                    <a href="https://www.google.com/" class="text-decoration-none contact-support-link">Contact support</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/login.js') }}"></script>
@endpush
