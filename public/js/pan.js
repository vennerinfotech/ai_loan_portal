document.addEventListener('DOMContentLoaded', function () {
    const panInput = document.getElementById('pan');
    const panForm = document.getElementById('panForm');
    const errorMessage = document.createElement('div');
    const successMessage = document.createElement('div');  // For success message
    const panInputContainer = document.querySelector('.verifications-input-container');

    // Regular expression for PAN format: XXXXX1234X (5 letters, 4 digits, 1 letter)
    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

    // Validate PAN input on each change
    panInput.addEventListener('input', function () {
        let value = panInput.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); // Allow only A-Z, 0-9
        panInput.value = value.substring(0, 10); // Limit to 10 characters
    });

    // Form submission handling
    panForm.addEventListener('submit', async function (e) {
        e.preventDefault();  // Prevent the default form submission behavior

        const rawPAN = panInput.value.trim();  // Get the value entered by the user

        // Reset previous error and success states
        panInput.classList.remove('shake');
        panInput.classList.remove('error');  // Remove error class
        panInput.style.border = '';  // Reset any inline border styles
        panInput.style.borderRadius = '';  // Reset border-radius
        errorMessage.innerHTML = '';  // Clear any previous error message
        successMessage.innerHTML = ''; // Clear any previous success message

        // Check if PAN format is valid
        if (!panRegex.test(rawPAN)) {
            showError('Invalid PAN number. Please enter the correct PAN number.');
            panInput.focus();
            return;
        }

        // If PAN is valid, proceed to store it in the database
        try {
            const response = await fetch(panForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    pan_card_number: rawPAN
                }),
            });

            const result = await response.json();  // Parse the response

            if (response.ok && result.success) {
                // If PAN is successfully stored, show success popup
                await Swal.fire({
                    icon: 'success',
                    title: 'PAN Verified!',
                    text: 'Your PAN number has been verified and stored successfully.',
                    confirmButtonText: 'Proceed',
                    confirmButtonColor: '#28a745'
                });

                // Redirect to the next page (e.g., OTP verification page)
                window.location.href = '/verify_pan_number';  // Replace with your next verification route
            } else {
                // If there's an error storing the PAN, show an error popup
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.error || 'Failed to store your PAN number. Please try again later.',
                    confirmButtonText: 'Try Again',
                    confirmButtonColor: '#d33'
                });
            }
        } catch (error) {
            // Handle network or other errors
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong. Please try again later.',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#d33'
            });
        }
    });

    // Function to show error message
    function showError(message) {
        // Apply error class to input field for styling
        panInput.classList.add('error');  // Add error class
        errorMessage.classList.add('pan-error-message');
        errorMessage.style.color = 'red';
        errorMessage.innerHTML = message;
        panInputContainer.appendChild(errorMessage);
        panInput.classList.add('shake');  // Add shake animation
        setTimeout(() => panInput.classList.remove('shake'), 500);
    }

    // Function to show success message
    function showSuccess(message) {
        successMessage.classList.add('pan-success-message');
        successMessage.innerHTML = message;
        panInputContainer.appendChild(successMessage);
    }
});










