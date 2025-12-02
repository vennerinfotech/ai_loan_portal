document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#registerForm");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const fullName = document.querySelector("#fullName").value.trim();
        const mobileNumber = document.querySelector("#mobileNumber").value.trim();
        const email = document.querySelector("#email").value.trim();

        if (!fullName || !mobileNumber || !email) {
            Swal.fire({
                icon: "warning",
                title: "Missing Fields",
                text: "Please fill all required fields before continuing.",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        // Simulate OTP send (for local development)
        const otp = "111111";
        localStorage.setItem("otp", otp);
        localStorage.setItem("mobile", mobileNumber);

        await Swal.fire({
            icon: "success",
            title: "OTP Sent!",
            html: `
                OTP sent successfully to <strong>${mobileNumber}</strong><br>
                <small>(Local Dev Mode: OTP is <b>${otp}</b>)</small>
            `,
            confirmButtonText: "Verify OTP",
            confirmButtonColor: "#28a745"
        });

        // Redirect to OTP verification page
        window.location.href = "/verify_otp";
    });
});
