@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @if (isset($expiresAt))
        <meta name="otp-expires-at" content="{{ $expiresAt->toIso8601String() }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="form-container-wrapper">
        <div class="container">
            <div class="form-container">
                <div class="left-section">
                    <div class="content">
                        <img src="{{ asset('images/logo-1.png') }}" alt="Logo" class="logo-image">
                        <h3>Verify for Reset MPIN</h3>
                    </div>
                </div>
                <div class="form-card">
                    <div class="otp-cards">
                        <div class="icon-circle">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>

                        <h3 class="mt-3">Verify Your Mobile</h3>
                        <p class="otp-subtitle">
                            We've sent a 6-digit code to <br>
                            <strong id="mobileDisplay">{{ $phone }}</strong>
                        </p>

                        <form class="otp-form" id="otpForm">
                            <div class="otp-inputs">
                                <input type="text" maxlength="1" class="otp-digit" required>
                                <input type="text" maxlength="1" class="otp-digit" required>
                                <input type="text" maxlength="1" class="otp-digit" required>
                                <input type="text" maxlength="1" class="otp-digit" required>
                                <input type="text" maxlength="1" class="otp-digit" required>
                                <input type="text" maxlength="1" class="otp-digit" required>
                            </div>

                            <div class="timer-section">
                                <p>Code expires in <br> <span id="timer"></span></p>
                            </div>

                            <button type="submit" class="btn-submit">Verify Code</button>

                            <div class="extra-links">
                                <p>Didn’t receive the code? <a href="#" id="resend"> Resend Code</a></p>
                                <a href="{{ route('forgot_mpin') }}" class="change-number"><img
                                        src="{{ asset('images/pencil.png') }}" alt="Vector Logo">
                                    Change phone number</a>
                            </div>

                            <div class="security-note">
                                <p>For your security, this code will expire in 2 minutes.<br>
                                    Don’t share this code with anyone.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Reusing verify_otp.js but we might need to override the fetch URL --}}
    {{-- We can inline the script or include a specific script --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const otpInputs = document.querySelectorAll(".otp-digit");
        const form = document.querySelector("#otpForm");
        const timerElement = document.querySelector("#timer");
        const resendLink = document.querySelector("#resend");
        
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Focus first box
        if(otpInputs.length > 0) otpInputs[0].focus();

        // Handle input typing and movement
        otpInputs.forEach((input, index) => {
            // ... (Same input handling logic as verify_otp.js) ...
            input.addEventListener("input", (e) => {
                const val = e.target.value;
                if (/[^0-9]/.test(val)) {
                    e.target.value = "";
                    return;
                }

                if (val && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                const enteredOtp = Array.from(otpInputs).map(i => i.value).join("");
                if (enteredOtp.length === 6) {
                    submitOtp();
                }
            });

            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        // Server-synced Countdown Timer
        const expiresMeta = document.querySelector('meta[name="otp-expires-at"]');
        let expiresAt = expiresMeta ? new Date(expiresMeta.content).getTime() : new Date().getTime() + 120000;
        let timerInterval;

        function startTimer() {
            clearInterval(timerInterval); // Clear any existing
            updateTimerDisplay(); // Immediate update
            
            timerInterval = setInterval(updateTimerDisplay, 1000);
        }

        function updateTimerDisplay() {
            const now = new Date().getTime();
            const distance = expiresAt - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                timerElement.textContent = "Expired";
                otpInputs.forEach(i => (i.disabled = true));
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timerElement.textContent = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
        }

        startTimer();

        // Manual verify
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            submitOtp();
        });

        // OTP Verification (Server-Side)
        function submitOtp() {
            const enteredOtp = Array.from(otpInputs).map(i => i.value).join("");
            
            if (enteredOtp.length < 6) {
                return; 
            }

            fetch("{{ route('forgot_mpin.verify_otp.post') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ otp: enteredOtp })
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return { success: true };
                }
                return response.json().catch(() => ({}));
            })
            .then(data => {
                if (data.success) {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                } else if (data.errors) {
                     Swal.fire({
                        icon: "error",
                        title: "Invalid OTP",
                        text: data.errors.otp || data.errors.error || "Invalid OTP",
                        confirmButtonColor: "#d33"
                    });
                     otpInputs[5].focus();
                }
            })
            .catch(err => console.error(err));
        }

        // Resend OTP (Server-Side)
        resendLink.addEventListener("click", (e) => {
            e.preventDefault();

            fetch("{{ route('forgot_mpin.resend_otp') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update expiry
                    expiresAt = new Date(data.expires_at).getTime();
                    
                    // Reset inputs
                    otpInputs.forEach(i => {
                        i.value = "";
                        i.disabled = false;
                    });
                    otpInputs[0].focus();
                    
                    // Restart timer
                    startTimer();

                    Swal.fire({
                        icon: "info",
                        title: "OTP Resent",
                        html: `A new OTP has been sent to your registered number.<br><b>(Local Dev Mode: OTP is ${data.otp})</b>`,
                        confirmButtonColor: "#3085d6"
                    });
                } else {
                     Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message,
                        confirmButtonColor: "#d33"
                    });
                }
            });
        });
    });
    </script>
@endpush
