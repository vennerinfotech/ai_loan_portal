document.addEventListener("DOMContentLoaded", () => {
    const otpInputs = document.querySelectorAll(".otp-digit");
    const form = document.querySelector("#otpForm");
    const timerElement = document.querySelector("#timer");
    const resendLink = document.querySelector("#resend");
    const mobileDisplay = document.querySelector("#mobileDisplay");
    
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Show mobile number from localStorage if present (fallback)
    // But mostly relying on server-rendered value now.
    // const mobile = localStorage.getItem("mobile");
    // if (mobile) mobileDisplay.textContent = mobile;

    // Focus first box
    if(otpInputs.length > 0) otpInputs[0].focus();

    // Handle input typing and movement
    otpInputs.forEach((input, index) => {
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
    // If meta exists, use it. Else default to 2 mins from now (fallback)
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
            // Optional: Auto-expire UI?
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
            // Only warn if manually submitted, not on auto-fill
            return; 
        }

        fetch('/verify-otp', {
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
                } else {
                     // Fallback check if redirected via fetch properties earlier
                     // (handled by response.redirected check above if generic)
                }
            } else if (data.errors) {
                 Swal.fire({
                    icon: "error",
                    title: "Invalid OTP",
                    text: data.errors.otp || data.errors.error || "Invalid OTP",
                    confirmButtonColor: "#d33"
                });
                otpInputs[5].focus();
            } else if (data.message && !data.success) {
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                    confirmButtonColor: "#d33"
                });
            }
        })
        .catch(err => console.error(err));
    }

    // Resend OTP (Server-Side)
    resendLink.addEventListener("click", (e) => {
        e.preventDefault();

        fetch('/resend-otp', {
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
                    // Use server provided OTP for dev display
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
