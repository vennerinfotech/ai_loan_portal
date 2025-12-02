document.addEventListener("DOMContentLoaded", () => {
    const otpInputs = document.querySelectorAll(".otp-digit");
    const form = document.querySelector("#otpForm");
    const timerElement = document.querySelector("#timer");
    const resendLink = document.querySelector("#resend");
    const mobileDisplay = document.querySelector("#mobileDisplay");

    // Show mobile number from localStorage
    const mobile = localStorage.getItem("mobile");
    if (mobile) mobileDisplay.textContent = mobile;

    // Focus first box
    otpInputs[0].focus();

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

    // Countdown Timer (2 minutes)
    let timeLeft = 120;
    const timerInterval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            timerElement.textContent = "Expired";
            otpInputs.forEach(i => (i.disabled = true));

            Swal.fire({
                icon: "error",
                title: "OTP Expired",
                text: "Your OTP has expired. Please resend to get a new code.",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        const minutes = String(Math.floor(timeLeft / 60)).padStart(2, "0");
        const seconds = String(timeLeft % 60).padStart(2, "0");
        timerElement.textContent = `${minutes}:${seconds}`;
        timeLeft--;
    }, 1000);

    // Manual verify
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        submitOtp();
    });

    // OTP Verification
    function submitOtp() {
        const enteredOtp = Array.from(otpInputs).map(i => i.value).join("");
        const storedOtp = localStorage.getItem("otp");

        if (enteredOtp.length < 6) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Code",
                text: "Please enter all 6 digits of your OTP.",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        if (enteredOtp === storedOtp) {
            Swal.fire({
                icon: "success",
                title: "OTP Verified Successfully!",
                text: "Redirecting to your MPIN setup...",
                confirmButtonColor: "#28a745",
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                localStorage.removeItem("otp");
                window.location.href = "/MPIN";
            });
        } else {
            //  Invalid OTP — show message but DO NOT clear inputs
            Swal.fire({
                icon: "error",
                title: "Invalid OTP",
                text: "The code you entered is incorrect. Please check and try again.",
                confirmButtonColor: "#d33"
            }).then(() => {
                // Keep existing OTP digits visible
                otpInputs[5].focus(); // Focus last input for quick edit
            });
        }
    }

    // Resend OTP
    resendLink.addEventListener("click", (e) => {
        e.preventDefault();

        Swal.fire({
            icon: "info",
            title: "OTP Resent",
            html: "A new OTP has been sent to your registered number.<br><b>(Use 111111 for local testing)</b>",
            confirmButtonColor: "#3085d6"
        });

        localStorage.setItem("otp", "111111");
        timeLeft = 120;
        otpInputs.forEach(i => {
            i.disabled = false;
        });
        otpInputs[0].focus();
    });
});
