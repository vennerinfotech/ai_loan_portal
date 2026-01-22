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
                        <h3 class="mt-3">Change Security MPIN</h3>
                    </div>
                    <form id="change-mpin-form" method="POST" action="{{ route('change.mpin.store') }}">
                        @csrf

                        {{-- Old MPIN --}}
                        <div class="pin-box">
                            <label class="fw-semibold mb-1">Enter Old 6-Digit MPIN</label>
                            <div class="mb-3">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box old-mpin"
                                    id="old-mpin-1" name="old_mpin[0]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box old-mpin"
                                    id="old-mpin-2" name="old_mpin[1]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box old-mpin"
                                    id="old-mpin-3" name="old_mpin[2]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box old-mpin"
                                    id="old-mpin-4" name="old_mpin[3]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box old-mpin"
                                    id="old-mpin-5" name="old_mpin[4]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box old-mpin"
                                    id="old-mpin-6" name="old_mpin[5]">
                            </div>
                            <div id="old-mpin-error-message" class="error-message text-danger">
                                @error('old_mpin')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        {{-- <hr style="margin: 20px 0; border-top: 1px dashed #ccc;"> --}}

                        {{-- New MPIN --}}
                        <div class="pin-box">
                            <label class="fw-semibold mb-1">Enter New 6-Digit MPIN</label>
                            <div class="mb-3">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box new-mpin"
                                    id="mpin-1" name="mpin[0]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box new-mpin"
                                    id="mpin-2" name="mpin[1]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box new-mpin"
                                    id="mpin-3" name="mpin[2]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box new-mpin"
                                    id="mpin-4" name="mpin[3]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box new-mpin"
                                    id="mpin-5" name="mpin[4]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box new-mpin"
                                    id="mpin-6" name="mpin[5]">
                            </div>
                            <div id="mpin-error-message" class="error-message text-danger"></div>

                            <label class="fw-semibold mb-1">Confirm New MPIN</label>
                            <div class="mb-3">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box confirm-mpin"
                                    id="cmpin-1" name="cmpin[0]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box confirm-mpin"
                                    id="cmpin-2" name="cmpin[1]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box confirm-mpin"
                                    id="cmpin-3" name="cmpin[2]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box confirm-mpin"
                                    id="cmpin-4" name="cmpin[3]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box confirm-mpin"
                                    id="cmpin-5" name="cmpin[4]">
                                <input type="password" inputmode="numeric" maxlength="1" class="mpin-box confirm-mpin"
                                    id="cmpin-6" name="cmpin[5]">
                            </div>
                            <div id="cmpin-error-message" class="error-message text-danger"></div>
                        </div>

                        <div class="mpin-req-box">
                            <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle"></i> MPIN Requirements</h6>
                            <ul class="small list-unstyled m-0">
                                <li id="req-length">
                                    <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Must be exactly 6
                                        digits</span>
                                </li>
                                <li id="req-sequential">
                                    <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Avoid sequential
                                        numbers (123456)</span>
                                </li>
                                <li id="req-repeated">
                                    <i class="bi bi-x-lg text-danger me-1"></i><span class="text-danger">Avoid repeated
                                        digits (111111)</span>
                                </li>
                                {{-- <li>
                                    <i class="bi bi-check-lg text-success me-1"></i><span class="text-success">Keep it
                                        confidential and memorable</span>
                                </li> --}}
                            </ul>
                        </div>


                        <button type="button" id="form-submit" class="btn-submit">
                            Update MPIN
                        </button>

                        <button type="button" class="btn-cancel"
                            onclick="window.location.href='{{ route('user_setting') }}'">
                            Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Reusing mpin.js but we need to adapt it slightly for the old MPIN fields if we want auto-tab there too --}}
    <script src="{{ asset('js/mpin.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add auto-tab to old-mpin fields
            const oldMpinInputs = document.querySelectorAll('.old-mpin');
            oldMpinInputs.forEach(input => {
                input.addEventListener('input', handleInput);
            });

            // Override the submit handler to check old MPIN length too
            const originalSubmit = document.getElementById('form-submit');
            // Remove the listener added by mpin.js and add a new one, or just add validation logic?
            // Since mpin.js adds listener on DOMContentLoaded, we might need to rely on the fact that mpin.js uses `getMPIN("mpin")`.

            // We'll create a new wrapper around generateMPIN to include old MPIN validation
            const newHandler = function(event) {
                event.stopImmediatePropagation(); // Try to stop the mpin.js handler if it's attached?
                // Actually mpin.js attaches to 'form-submit' ID.
                // Let's just create a custom validation here that calls the original logic or duplicates it.
                // To minimize complexity, I'll modify mpin.js or just add specific checks here.

                // Let's do a quick validation here
                let oldMpin = "";
                for (let i = 1; i <= 6; i++) {
                    let el = document.getElementById(`old-mpin-${i}`);
                    if (el) oldMpin += el.value;
                }

                if (oldMpin.length !== 6) {
                    event.preventDefault();
                    document.getElementById("old-mpin-error-message").textContent =
                        'Please enter your Old 6-digit MPIN.';
                    // Add red border
                    document.querySelectorAll('.old-mpin').forEach(input => input.classList.add('input-error'));
                    return;
                } else {
                    document.getElementById("old-mpin-error-message").textContent = '';
                    document.querySelectorAll('.old-mpin').forEach(input => input.classList.remove(
                        'input-error'));
                }

                // If old MPIN is fine, let the standard validation proceed?
                // mpin.js is included, so it will run generateMPIN.
                // However, we need to make sure generateMPIN doesn't submit if OLD mpin is invalid.
                // But generateMPIN is attached to the same button.

                // Instead of fighting mpin.js, let's just use it but add the old mpin check inside it?
                // Or we can clone the button?
                // Let's just create a separate script here that validates everything and submits.

                // BETTER: Update mpin.js to be more flexible? OR override it here.

                // Reuse logic from mpin.js manually
                const mpin = getMPIN("mpin");
                const confirm = getMPIN("cmpin");

                // ... (Re-run validations) ...
                // Actually, mpin.js is globally scoped functions.
                // generateMPIN calls getMPIN, isSequential, etc.

                // So we can overwrite generateMPIN in this scope!

            };

            // Remove the existing listener if possible (hard without reference)
            // Instead, let's Replace the element to strip listeners
            const btn = document.getElementById('form-submit');
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);

            newBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // 1. Validate Old MPIN
                let oldMpin = "";
                let oldMpinComplete = true;
                for (let i = 1; i <= 6; i++) {
                    let el = document.getElementById(`old-mpin-${i}`);
                    if (el) {
                        oldMpin += el.value;
                        if (!el.value) oldMpinComplete = false;
                    }
                }

                if (!oldMpinComplete) {
                    document.getElementById("old-mpin-error-message").textContent =
                        'Please enter complete Old MPIN.';
                    return;
                }

                // 2. Validate New MPIN using existing functions from mpin.js
                const mpin = getMPIN("mpin");
                const confirm = getMPIN("cmpin");

                // Clear previous errors
                document.getElementById("mpin-error-message").textContent = '';
                document.getElementById("cmpin-error-message").textContent = '';
                document.getElementById("old-mpin-error-message").textContent = '';

                // Re-run the requirement check
                updateRequirements();

                if (mpin.length !== 6 || confirm.length !== 6) {
                    document.getElementById("mpin-error-message").textContent =
                        'Please enter a complete 6-digit MPIN in both fields.';
                    return;
                }

                if (mpin !== confirm) {
                    document.getElementById("cmpin-error-message").textContent =
                        'The MPIN and Confirm MPIN do not match!';
                    return;
                }

                if (isSequential(mpin)) {
                    document.getElementById("mpin-error-message").textContent =
                        'MPIN should not be sequential.';
                    return;
                }

                if (isRepeated(mpin)) {
                    document.getElementById("mpin-error-message").textContent =
                        'MPIN should not contain repeated digits.';
                    return;
                }

                // Submit
                document.getElementById("change-mpin-form").submit();
            });
        });
    </script>
@endpush
