document.addEventListener('DOMContentLoaded', () => {
    const otpBoxes = document.querySelectorAll('.otp-box');
    const otpForm = document.getElementById('otpForm');
    const timerElement = document.getElementById('timer');
    const resendOtpLink = document.getElementById('resend-otp');

    // Store demo OTP for local testing
    const demoOtp = "111111";
    localStorage.setItem("aadhaarOtp", demoOtp);

    let timeLeft = 120;

    // Focus first box
    otpBoxes[0].focus();

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
            if (enteredOtp.length === 6) {
                submitOtp();
            }
        });

        box.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && !box.value && index > 0) {
                otpBoxes[index - 1].focus();
            }
        });
    });

    // Countdown timer
    const interval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(interval);
            timerElement.textContent = "Expired";
            otpBoxes.forEach(i => i.disabled = true);

            Swal.fire({
                icon: 'error',
                title: 'OTP Expired',
                text: 'Your OTP has expired. Please resend to get a new code.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        timerElement.textContent = timeLeft;
        timeLeft--;
    }, 1000);

    // Resend OTP
    resendOtpLink.addEventListener('click', (e) => {
        e.preventDefault();

        Swal.fire({
            icon: 'info',
            title: 'OTP Resent',
            html: 'A new OTP has been sent to your registered mobile number.<br><b>(Use 111111 for local testing)</b>',
            confirmButtonColor: '#3085d6'
        });

        localStorage.setItem("aadhaarOtp", demoOtp);
        timeLeft = 30;
        otpBoxes.forEach(i => i.disabled = false);
        otpBoxes.forEach(i => i.value = '');
        otpBoxes[0].focus();
        resendOtpLink.style.display = 'none';

        // Restart timer
        const newInterval = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(newInterval);
                timerElement.textContent = "Expired";
                otpBoxes.forEach(i => i.disabled = true);
                resendOtpLink.style.display = 'inline';
            } else {
                timerElement.textContent = timeLeft;
                timeLeft--;
            }
        }, 1000);
    });

    // OTP submission
    otpForm.addEventListener('submit', (e) => {
        e.preventDefault();
        submitOtp();
    });


    function submitOtp() {
        const enteredOtp = Array.from(otpBoxes).map(i => i.value).join('');
        const storedOtp = localStorage.getItem("aadhaarOtp");

        if (enteredOtp.length < 6) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete OTP',
                text: 'Please enter all 6 digits of the OTP.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        if (enteredOtp === storedOtp) {
            Swal.fire({
                icon: 'success',
                title: 'OTP Verified Successfully!',
                text: 'Redirecting to the next step...',
                confirmButtonColor: '#28a745',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                localStorage.removeItem("aadhaarOtp");
                window.location.href = '/upload_aadhaar_document'; // Change to your next route
            });
        } else {
            // Custom Invalid OTP Popup
            const popupHtml = `
                <div class="aadhaar-popup text-center p-4">
                    <div class="icon mb-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    </div>
                    <h5 class="fw-semibold">Aadhaar Not Linked with Mobile</h5>
                    <p class="text-muted small">We could not send OTP. Please upload your Aadhaar card for manual verification.</p>
                    <button id="upload-aadhaar-btn" class="button upload-aadhaar-btn w-100 mb-2">Upload Aadhaar</button>
                    <button id="cancel-btn" class="button cancel-btn w-100">Cancel</button>
                </div>`;

            const popupDiv = document.createElement('div');
            popupDiv.classList.add('aadhaar-popup-wrapper');
            popupDiv.innerHTML = popupHtml;
            document.body.appendChild(popupDiv);

            // Handle button clicks
            document.getElementById('upload-aadhaar-btn').addEventListener('click', () => {
                window.location.href = '/upload_aadhaar_document'; // Your upload page
            });
            document.getElementById('cancel-btn').addEventListener('click', () => {
                popupDiv.remove();
            });
        }
    }

});
