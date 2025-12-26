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
                        <h3>Secure Your Account<br> With a MPIN</h3>
                    </div>
                </div>
                <div class="form-card">
                        <div class="mb-4">
                            <div class="icon-circle">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h3 class="mt-3">Create New Security MPIN?</h3>
                        </div>
                        <form id="mpin-form" method="POST" action="#">
                            @csrf
                            <div class="pin-box">
                                <label class="fw-semibold mb-1">Enter New 6-Digit MPIN</label>
                                <div class="mb-3">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="mpin-1" name="mpin[0]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="mpin-2" name="mpin[1]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="mpin-3" name="mpin[2]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="mpin-4" name="mpin[3]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="mpin-5" name="mpin[4]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="mpin-6" name="mpin[5]">

                                </div>
                                <div id="mpin-error-message" class="error-message text-danger"></div>
                                <label class="fw-semibold mb-1">Confirm MPIN</label>
                                <div class="mb-3">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="cmpin-1" name="cmpin[0]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="cmpin-2" name="cmpin[1]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="cmpin-3" name="cmpin[2]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="cmpin-4" name="cmpin[3]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="cmpin-5" name="cmpin[4]">
                                    <input type="password" inputmode="numeric" maxlength="1" class="mpin-box"
                                        id="cmpin-6" name="cmpin[5]">
                                </div>
                                <div id="cmpin-error-message" class="error-message text-danger"></div>
                            </div>
                            <div class="mpin-req-box">
                                <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle"></i> MPIN Requirements</h6>
                                <ul class="small list-unstyled m-0">
                                    <li id="req-length">
                                        <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Must be
                                            exactly 6
                                            digits</span>
                                    </li>
                                    <li id="req-sequential">
                                        <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Avoid
                                            sequential numbers
                                            (123456)</span>
                                    </li>
                                    <li id="req-repeated">
                                        <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Avoid
                                            repeated digits
                                            (111111)</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-lg text-success me-1"></i><span class="text-success">Keep it
                                            confidential and memorable</span>
                                    </li>
                                </ul>
                            </div>


                            <button type="button" id="form-submit" class="btn-submit">
                                Generate MPIN
                            </button>

                            <button type="button" class="btn-cancel">
                                Cancel
                            </button>
                        </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/mpin.js') }}"></script>
@endpush
