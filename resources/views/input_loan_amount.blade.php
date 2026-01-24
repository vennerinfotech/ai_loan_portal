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
                                        <input type="text" id="loanAmount" name="loanAmount"
                                            placeholder="Enter Loan Amount" autocomplete="off" class="form-control"
                                            inputmode="numeric" pattern="[0-9]*">

                                        <button type="button" class="aadhaar-toggle-visibility" id="toggleBtn">
                                            <i class="bi bi-shield-shaded"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="loan-input-select">
                                    <a href="#" class="btn-select" data-amount="100000">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>1,00,000
                                    </a>

                                    <a href="#" class="btn-select" data-amount="500000">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>5,00,000
                                    </a>

                                    <a href="#" class="btn-select" data-amount="1000000">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>10,00,000
                                    </a>
                                </div>

                                <div class="loan-input-btn">
                                    <a href="{{ route('apply_for_loan') }}" class="btn-cancel" id=""><i
                                            class="fa-solid fa-arrow-left pr-2"></i>Back</a>
                                    <a href="{{ route('enter-aadhaar') }}" class="btn-submit" id="">Continue</a>
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
    <script src="{{ asset('js/input_loan_amount.js') }}"></script>
@endpush
