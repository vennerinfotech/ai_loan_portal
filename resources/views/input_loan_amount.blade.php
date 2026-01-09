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
                        <div class="info">
                            <p>Empowering your financial goals with quick and secure loan solutions.</p>
                        </div>

                    </div>
                </div>
                <div class="form-card">
                    <div class="mb-4">
                        <div class="icon-circle">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                        </div>
                        <h3 class="mt-4">Loan Application</h3>
                        <p>Enter the amount you would like to borrow for your requirment</p>
                    </div>
                    <div class="aadhaar-container">
                        <div class="aadhaar-card">

                            <form class="aadhaar-form" method="POST" action="{{ route('store-aadhaar') }}">
                                @csrf

                                <!-- Success and Error Messages -->
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="aadhaar">Enter Loan Amount</label>
                                    <div class="aadhaar-input-container">
                                        <input type="text" id="" name="aadhaar_number"
                                            placeholder="Enter Loan Amount" autocomplete="off" class="form-control"
                                            value="">


                                        <!-- Show validation error for aadhaar_number field -->
                                        @error('aadhaar_number')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <button type="button" class="aadhaar-toggle-visibility" id="toggleBtn">
                                            <i class="bi bi-shield-shaded"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="loan-input-select">
                                    <a href="#" class="btn-select" id=""><i class="fa-solid fa-indian-rupee-sign"></i>1,00,000</a>
                                    <a href="#" class="btn-select" id=""><i class="fa-solid fa-indian-rupee-sign"></i>5,00,000</a>
                                    <a href="#" class="btn-select" id=""><i class="fa-solid fa-indian-rupee-sign"></i>10,00,000</a>
                                </div>
                                <div class="loan-input-btn">
                                    <a href="{{ route('apply_loan') }}" class="btn-cancel" id=""><i class="fa-solid fa-arrow-left pr-2"></i>Back</a>
                                    <button type="submit" class="btn-submit" id="continueBtn">Continue</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
