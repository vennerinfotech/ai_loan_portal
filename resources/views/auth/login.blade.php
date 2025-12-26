@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('body-class', 'bg-light')

@section('content')
    <div class="login-page-wrapper form-container-wrapper">
        <div class="container">
            <div class="form-container">
                <div class="left-section">
                    <div class="content">
                        <i class="fa-solid fa-user-lock"></i>
                        <h3>Welcome back</h3>
                    </div>
                </div>
                <div class="form-card">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <h2 style="font-weight: 600;">LOGO</h2>
                            <h6>Login to continue to your account</h6>
                        </div>
                        <form id="loginForm" action="{{ route('login.authenticate') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email">
                                    @error('email')
                                        <div class="error-message text-danger">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Enter MPIN</label>
                                <input type="password" class="form-control" id="password" name="mpin"
                                    placeholder="6 Digit Security MPIN">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                                @error('mpin')
                                    <div class="error-message text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Display session error message -->
                            @if (session('error'))
                                <div class="error-message text-danger mb-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-end align-items-center mb-4">
                                 <a href="{{ route("forgot_mpin") }}" class="text-decoration-none MPIN-link">Forgot Security MPIN?</a>
                            </div>

                            <button type="submit" class="btn-submit">
                                Sign in with MPIN <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>

                        <p class="bottom-text">
                            Don't have an account? <a href="{{ route('register.create') }}"
                                class="text-decoration-none sign-up-link">Sign up</a>
                        </p>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/login.js') }}"></script>
@endpush
