document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.aadhaar-form');
    const aadhaarInput = document.getElementById('aadhaar');
    const errorMessage = document.createElement('div');
    const successMessage = document.createElement('div'); // For success message
    const aadhaarInputContainer = document.querySelector('.aadhaar-input-container');
    const toggleBtn = document.getElementById('toggleBtn');
    let isVisible = false;

    // Regular expression to only allow digits
    const digitRegex = /^\d*$/;

    // Validate Aadhaar number on input (allow only digits)
    aadhaarInput.addEventListener('input', function () {
        if (!digitRegex.test(aadhaarInput.value)) {
            aadhaarInput.value = aadhaarInput.value.replace(/[^\d]/g, '');  // Remove non-digit characters
        }
    });

    form.addEventListener('submit', async function (e) {
        e.preventDefault();  // Prevent the default form submission behavior

        const originalValue = aadhaarInput.value.replace(/\D/g, ''); // Get only digits

        // Reset error state before validation
        aadhaarInput.classList.remove('shake');
        aadhaarInput.style.border = '';  // Remove any border styles from input
        aadhaarInput.style.borderRadius = '';  // Reset border-radius on input
        errorMessage.innerHTML = '';  // Clear the error message
        successMessage.innerHTML = ''; // Clear success message

        // Validate Aadhaar number length (12 digits)
        if (originalValue.length !== 12) {
            // showError('Aadhaar number must be 12 digits long.');
            showError('Aadhaar number is required.');
            aadhaarInput.focus();
            return;
        }

        // If valid, show success message
        showSuccess(`Aadhaar number ${originalValue} stored successfully.`);

        // If valid, show success popup
        await Swal.fire({
            icon: 'success',
            title: 'Aadhaar Verified!',
            html: `Aadhaar <strong>${originalValue}</strong> verification initiated successfully.<br>
                   <small>(This is a demo popup)</small>`,
            confirmButtonText: 'Proceed',
            confirmButtonColor: '#28a745'
        });

        // After the popup, submit the form to the server
        form.submit();
    });

    // Toggle visibility of Aadhaar number (mask/unmask)
    toggleBtn.addEventListener('click', function () {
        isVisible = !isVisible;
        aadhaarInput.value = isVisible ? aadhaarInput.value.replace(/\D/g, '') : maskAadhaar(aadhaarInput.value);
        toggleBtn.innerHTML = isVisible
            ? `<i class="bi bi-shield-shaded"></i>`  // Show unmasked icon
            : `<i class="bi bi-shield-slash-fill"></i>`;  // Show masked icon
    });

    // Function to show error
    function showError(message) {
        // Apply red border with rounded corners (8px radius) and display error message
        aadhaarInput.style.border = '1px solid red';  // Red border on input
        aadhaarInput.style.borderRadius = '8px';  // 8px rounded corners
        errorMessage.classList.add('aadhaar-error-message');
        errorMessage.innerHTML = message;
        aadhaarInputContainer.appendChild(errorMessage);
        aadhaarInput.classList.add('shake');
        setTimeout(() => aadhaarInput.classList.remove('shake'), 500);
    }

    // Function to show success message
    function showSuccess(message) {
        successMessage.classList.add('aadhaar-success-message');
        successMessage.innerHTML = message;
        aadhaarInputContainer.appendChild(successMessage);
    }

    // Mask Aadhaar number to hide digits
    function maskAadhaar(value) {
        return value.replace(/\d(?=\d{4})/g, "*");
    }
});


