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
                            <h4>Secure Verification</h4>
                            <p>Your Aadhaar details are encrypted with industry-standard protocols ensuring complete privacy
                                and security.</p>
                        </div>
                    </div>
                </div>
                <div class="form-card text-center">
                    <div class="mb-4">
                        <div class="icon-circle mx-auto warning">
                            <i class="fa-solid fa-warning"></i>
                        </div>
                        <h3 class="mt-4">Aadhaar Not Linked with Mobile</h3>
                        <p>We could not send OTP. Please upload your Aadhaar card for manual verification.</p>
                    </div>

                    <div class="">
                         <a href="{{ route('upload_aadhaar_doc') }}" class="btn-submit">Upload Aadhaar Card</a>
                        <a href="#" class="btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

