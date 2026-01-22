@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
    <div class="form-container-wrapper">
        <div class="container">
            <div class="form-container">
                <div class="left-section">
                    <div class="content">
                        <img src="{{ asset('images/logo-1.png') }}" alt="Logo" class="logo-image">
                        <h3>Forgot MPIN?</h3>
                    </div>
                </div>
                <div class="form-card">
                    <div class="">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="mt-3">Enter Mobile Number</h3>
                        <p class="otp-subtitle">
                            Enter your registered mobile number to reset your MPIN.
                        </p>
                    </div>

                    <form id="forgotMpinForm" action="{{ route('forgot_mpin.send_otp') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="phone" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Enter your mobile number" maxlength="10" inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('phone')
                                <div class="error-message text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            Send OTP
                        </button>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #666;">Back to
                                Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
