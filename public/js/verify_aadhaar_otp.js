document.addEventListener('DOMContentLoaded', () => {
    const otpBoxes = document.querySelectorAll('.otp-box');
    const otpForm = document.getElementById('otpForm');
    const timerElement = document.getElementById('timer');
    const resendOtpLink = document.getElementById('resend-otp');
    const aadhaarNumberInput = document.getElementById('aadhaar_number');

    const timerText = document.getElementById('timer-text');

    // Timer Duration in seconds
    const TIMER_DURATION = 77;
    const STORAGE_KEY = 'aadhaar_rx_timer_expiry';

    // Focus first box
    if (otpBoxes.length > 0) otpBoxes[0].focus();

    // Handle input typing and movement
    otpBoxes.forEach((box, index) => {
        box.addEventListener('input', (e) => {
            const val = e.target.value;
            if (/[^0-9]/.test(val)) {
                e.target.value = '';
                return;
            }

            if (val && index < otpBoxes.length - 1) {
                otpBoxes[index + 1].focus();
            }

            const enteredOtp = Array.from(otpBoxes).map(i => i.value).join('');
            // Auto submit if needed, or just let user click verify
        });

        box.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && !box.value && index > 0) {
                otpBoxes[index - 1].focus();
            }
        });
    });

    // --- Persistent Timer Logic ---
    let interval;

    function startTimer() {
        // Check if there is an existing expiry time
        let expiryTime = localStorage.getItem(STORAGE_KEY);
        const now = Date.now();

        if (!expiryTime || parseInt(expiryTime) < now) {
            if(!expiryTime) {
                expiryTime = now + (TIMER_DURATION * 1000);
                localStorage.setItem(STORAGE_KEY, expiryTime);
            }
        }
        
        updateTimerUI(expiryTime);

        interval = setInterval(() => {
            updateTimerUI(expiryTime);
        }, 1000);
    }

    function updateTimerUI(expiryTime) {
        const now = Date.now();
        const timeLeftMs = parseInt(expiryTime) - now;
        const timeLeftSec = Math.ceil(timeLeftMs / 1000);

        if (timeLeftSec <= 0) {
            clearInterval(interval);
            
            // Show Expired text
            timerText.innerHTML = '<span class="text-danger fw-bold">Expired</span>';
            otpBoxes.forEach(i => i.disabled = true);
            
            // Show Resend Link
            resendOtpLink.style.display = 'inline';
            resendOtpLink.style.pointerEvents = 'auto';
            resendOtpLink.style.color = ''; // Reset color
            
        } else {
            // Restore counting text
            timerText.innerHTML = `Resend OTP in <span id="timer" class="text-danger fw-semibold">${timeLeftSec}</span> s`;
            
            resendOtpLink.style.display = 'none'; // Hide resend link while counting
        }
    }

    // Initialize Timer
    startTimer();


    // --- Resend OTP Logic ---
    resendOtpLink.addEventListener('click', (e) => {
        e.preventDefault();

        const aadhaarNumber = aadhaarNumberInput ? aadhaarNumberInput.value : '';

        if (!aadhaarNumber) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Aadhaar number not found. Please try again from start.',
            });
            return;
        }

        // Disable link to prevent double click
        resendOtpLink.style.pointerEvents = 'none';

        fetch('/aadhaar-resend-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ aadhaar_number: aadhaarNumber })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Resent',
                    text: 'A new OTP has been sent to your registered mobile number.',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Reset inputs
                otpBoxes.forEach(i => i.value = '');
                otpBoxes.forEach(i => i.disabled = false);
                otpBoxes[0].focus();

                // Reset Timer
                const now = Date.now();
                const newExpiry = now + (TIMER_DURATION * 1000);
                localStorage.setItem(STORAGE_KEY, newExpiry);
                
                // Restart Interval
                clearInterval(interval);
                startTimer();

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: data.message || 'Could not resend OTP.',
                });
                resendOtpLink.style.pointerEvents = 'auto';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong. Please try again.',
            });
            resendOtpLink.style.pointerEvents = 'auto';
        });
    });

    // --- Form Submission ---
    otpForm.addEventListener('submit', (e) => {
        // We let the form submit naturally to the backend for verification
        // But we check if inputs are filled
        const enteredOtp = Array.from(otpBoxes).map(i => i.value).join('');
        if (enteredOtp.length < 6) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete OTP',
                text: 'Please enter all 6 digits of the OTP.',
                confirmButtonColor: '#3085d6'
            });
        }
        // If valid, form submits POST to /verify-aadhaar-otp
    });
});

