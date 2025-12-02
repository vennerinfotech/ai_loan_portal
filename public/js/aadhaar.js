document.addEventListener('DOMContentLoaded', function() {
    const aadhaarInput = document.getElementById('aadhaar');
    const toggleBtn = document.getElementById('toggleBtn');
    const continueBtn = document.getElementById('continueBtn');
    const helpLink = document.getElementById('helpLink');
    const form = document.querySelector('.aadhaar-form');

    let isVisible = false;
    let originalValue = '';

    // Error message element
    let errorMsg = document.createElement('div');
    errorMsg.className = 'aadhaar-error text-danger small mt-1';
    aadhaarInput.parentNode.appendChild(errorMsg);

    // Format Aadhaar number
    function formatAadhaar(value) {
        const digits = value.replace(/\D/g, '');
        const limitedDigits = digits.substring(0, 12);
        return limitedDigits.replace(/(\d{4})(?=\d)/g, '$1 ');
    }

    // Mask Aadhaar number
    function maskAadhaar(value) {
        const digits = value.replace(/\D/g, '');
        if (digits.length <= 8) {
            return digits.replace(/\d/g, 'X').replace(/(\w{4})(?=\w)/g, '$1 ');
        }
        const masked = 'X'.repeat(8) + digits.substring(8);
        return masked.replace(/(\w{4})(?=\w)/g, '$1 ');
    }

    // Input formatting
    aadhaarInput.addEventListener('input', function(e) {
        const cursorPosition = e.target.selectionStart;
        const oldLength = e.target.value.length;
        originalValue = formatAadhaar(e.target.value);

        e.target.value = isVisible ? originalValue : maskAadhaar(originalValue);

        const newLength = e.target.value.length;
        const newPosition = cursorPosition + (newLength - oldLength);
        e.target.setSelectionRange(newPosition, newPosition);

        updateContinueButton();
        clearError();
    });

    // Toggle visibility
    toggleBtn.addEventListener('click', function() {
        isVisible = !isVisible;
        aadhaarInput.value = isVisible ? originalValue : maskAadhaar(originalValue);
        toggleBtn.innerHTML = isVisible
            ? `<i class="bi bi-shield-shaded"></i>`
            : `<i class="bi bi-shield-slash-fill"></i>`;
    });

    // Enable/disable continue
    function updateContinueButton() {
        const digits = originalValue.replace(/\D/g, '');
        continueBtn.disabled = digits.length !== 12;
        if (digits.length === 12) clearError();
    }

    // Show error message
    function showError(msg) {
        aadhaarInput.classList.add('input-error');
        errorMsg.innerText = msg;
    }

    function clearError() {
        aadhaarInput.classList.remove('input-error');
        errorMsg.innerText = '';
    }

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const digits = originalValue.replace(/\D/g, '');

        if (digits.length !== 12) {
            showError('Aadhaar number is required and must be 12 digits.');
            aadhaarInput.classList.add('shake');
            setTimeout(() => aadhaarInput.classList.remove('shake'), 500);
            aadhaarInput.focus();
            return;
        }

        // SweetAlert2 popup
        await Swal.fire({
            icon: 'success',
            title: 'Aadhaar Verified!',
            html: `Aadhaar <strong>${digits}</strong> verification initiated successfully.<br>
                   <small>(This is a demo popup)</small>`,
            confirmButtonText: 'Proceed',
            confirmButtonColor: '#28a745'
        });

        // Redirect to OTP page
        window.location.href = "/aadhaar_verify_otp"; // Your OTP page route
    });

    // Help link
    helpLink.addEventListener('click', function(e) {
        e.preventDefault();
        alert('Help: Please enter your 12-digit Aadhaar number. If you need assistance, contact our support team.');
    });

    updateContinueButton();
    aadhaarInput.focus();
});
