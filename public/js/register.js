document.getElementById('form-submit').addEventListener('click', function (e) {
    // Clear previous error messages and styling
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(message => message.remove());

    const fields = document.querySelectorAll('.input-group input');
    fields.forEach(field => field.classList.remove('is-invalid')); // Remove previous invalid styling

    let isValid = true;

    // Validate Full Name (required field)
    const fullName = document.getElementById('fullName');
    if (!fullName.value.trim()) {
        isValid = false;
        showError(fullName, "Full Name is required.");
    }

    // Validate Phone Number (must be 10 digits)
    const phone = document.getElementById('mobileNumber');
    const phoneRegex = /^[0-9]{10}$/;
    if (!phone.value.trim()) {
        isValid = false;
        showError(phone, "Phone number is required.");
    } else if (!phoneRegex.test(phone.value)) {
        isValid = false;
        showError(phone, "Please enter a valid 10-digit phone number.");
    }

    // Validate Email (Optional)
    const email = document.getElementById('email');
    if (email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
         isValid = false;
         showError(email, "Please enter a valid email address.");
    }

    // Validate PAN Card Number (ABCDE1234F format)
    const panCard = document.getElementById('panNumber');
    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    if (panCard.value && !panRegex.test(panCard.value)) {
        isValid = false;
        showError(panCard, "Please enter a valid PAN card number (ABCDE1234F).");
    }

    // Validate Reference Code (ACB123 format)
    const referenceCode = document.getElementById('referralCode');
    const referenceRegex = /^[A-Z]{3}[0-9]{3}$/;
    if (referenceCode.value && !referenceRegex.test(referenceCode.value)) {
        isValid = false;
        showError(referenceCode, "Please enter a valid reference code (ACB123).");
    }

    // If form is not valid, prevent submission
    if (!isValid) {
        e.preventDefault(); // Prevent form submission
        return;
    }

    // Simulate OTP sending (For local dev, we generate a fixed OTP)
    const otp = "111111";  // Simulating OTP for local development
    localStorage.setItem("otp", otp);
    localStorage.setItem("mobile", phone.value.trim());

    // Show success message (OTP sent)
    Swal.fire({
        icon: "success",
        title: "OTP Sent!",
        html: `
            OTP sent successfully to <strong>${phone.value}</strong><br>
            <small>(Local Dev Mode: OTP is <b>${otp}</b>)</small>
        `,
        confirmButtonText: "Verify OTP",
        confirmButtonColor: "#28a745"
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to OTP verification page after user clicks the "Verify OTP" button
            window.location.href = "/verify_otp";  // Replace with your actual OTP verification route
        }
    });
});

// Function to show error messages below the field
function showError(field, message) {
    // Add red border to the field
    field.classList.add('is-invalid');

    // Create and append error message below the field
    const errorMessage = document.createElement('div');
    errorMessage.classList.add('error-message');
    errorMessage.textContent = message;
    field.parentElement.appendChild(errorMessage);
}
