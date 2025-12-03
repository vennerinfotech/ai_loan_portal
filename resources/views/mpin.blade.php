@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/mpin.css') }}">
@endsection

@section('body-class', 'mpin-bg')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100 mpin-bg">
        <div class="mpin-card shadow p-4 rounded-4">

            <div class="text-center mb-4">
                <div class="icon-circle mx-auto icon-square">
                    <i class="bi bi-lock-fill"></i>
                </div>
                <h3 class="fw-bold mt-3">Generate Your MPIN</h3>
                <p class="text-muted">Create a secure 6-digit MPIN for your account</p>
            </div>
            <form id="mpin-form" method="POST" action="{{ route('mpin.store') }}">
                @csrf
                <div class="pin-box">
                    <label class="fw-semibold mb-1">Enter 6-Digit MPIN</label>
                    <div class="d-flex justify-content-between mb-3">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="mpin-1"
                            name="mpin[0]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="mpin-2"
                            name="mpin[1]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="mpin-3"
                            name="mpin[2]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="mpin-4"
                            name="mpin[3]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="mpin-5"
                            name="mpin[4]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="mpin-6"
                            name="mpin[5]">

                    </div>
                    <div id="mpin-error-message" class="error-message text-danger"></div>
                    <label class="fw-semibold mb-1">Confirm MPIN</label>
                    <div class="d-flex justify-content-between mb-3">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="cmpin-1"
                            name="cmpin[0]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="cmpin-2"
                            name="cmpin[1]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="cmpin-3"
                            name="cmpin[2]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="cmpin-4"
                            name="cmpin[3]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="cmpin-5"
                            name="cmpin[4]">
                        <input type="password" inputmode="numeric" maxlength="1" class="mpin-box" id="cmpin-6"
                            name="cmpin[5]">
                    </div>
                    <div id="cmpin-error-message" class="error-message text-danger"></div>
                </div>
                <div class="p-3 rounded-3 mpin-req-box mb-3">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle"></i> MPIN Requirements</h6>
                    <ul class="small list-unstyled m-0">
                        <li id="req-length">
                            <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Must be exactly 6
                                digits</span>
                        </li>
                        <li id="req-sequential">
                            <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Avoid sequential numbers
                                (123456)</span>
                        </li>
                        <li id="req-repeated">
                            <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Avoid repeated digits
                                (111111)</span>
                        </li>
                        <li>
                            <i class="bi bi-check-lg text-success me-1"></i><span class="text-success">Keep it
                                confidential and memorable</span>
                        </li>
                    </ul>
                </div>


                <button type="button" id="form-submit" class="btn btn-primary w-100 mb-2 gradient-btn">
                    Generate MPIN
                </button>

                <button class="btn btn-outline-secondary w-100">
                    Cancel
                </button>
            </form>
            <p class="text-center small text-muted mt-3">
                <i class="bi bi-shield-shaded" style="color: rgba(79, 70, 229, 1);"></i> Your MPIN is encrypted and stored
                securely
            </p>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/mpin.js') }}"></script>
@endpush
