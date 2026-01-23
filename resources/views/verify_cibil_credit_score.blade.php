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
                            <h4>Credit Report</h4>
                            <p>Get your latest credit report in seconds. Check your score and understand your financial
                                standing.</p>
                        </div>

                    </div>
                </div>
                <div class="form-card">
                    <div class="mb-4 text-center">
                        <div class="icon-circle mx-auto">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <h3 class="mt-3">Credit Report Verified Successfully</h3>
                        <p> Your credit report has been fetched and analyzed. You can now continue with your loan
                            application.</p>
                        <a href="{{route('applicant_detail')}}" class="btn-submit">
                            Proceed to Loan Application
                        </a>

                        <a href="/credit-report-details" class="btn-cancel">
                            View Credit Report Details
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="{{ asset('js/verify_pan.js') }}"></script> --}}
@endpush
