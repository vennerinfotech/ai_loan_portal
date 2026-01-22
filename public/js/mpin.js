// Function to combine individual input fields into a single 6-digit string
function getMPIN(prefix) {
    let mpin = "";
    for (let i = 1; i <= 6; i++) {
        mpin += document.getElementById(`${prefix}-${i}`).value;
    }
    return mpin;
}

// Checks for sequential numbers (e.g., 123456, 654321)
function isSequential(num) {
    const seqAsc = "123456";
    const seqDesc = "654321";
    return num === seqAsc || num === seqDesc;
}

// Checks for repeated digits (e.g., 111111, 222222)
function isRepeated(num) {
    return /^(\d)\1+$/.test(num); // Regex to check if all digits are the same (e.g., 111111)
}

// Real-Time Requirements Update Function
function updateRequirements() {
    const mpin = getMPIN("mpin");

    // 1. Length Requirement (Must be exactly 6 digits)
    const lengthValid = mpin.length === 6;
    updateIcon('req-length', lengthValid);

    // 2. Sequential Requirement (Avoid sequential)
    // Only valid if length is 6 AND not sequential
    const sequentialValid = mpin.length === 6 && !isSequential(mpin);
    updateIcon('req-sequential', sequentialValid);

    // 3. Repeated Requirement (Avoid repeated)
    // Only valid if length is 6 AND not repeated
    const repeatedValid = mpin.length === 6 && !isRepeated(mpin);
    updateIcon('req-repeated', repeatedValid);
}

// Helper function to update the icon and text color
function updateIcon(elementId, isValid) {
    const li = document.getElementById(elementId);
    if (!li) return;

    let icon = li.querySelector('i');
    if (!icon) {
        icon = document.createElement('i');
        li.prepend(icon);
    }

    let text = li.querySelector('span');
    if (!text) {
        text = document.createElement('span');
        li.appendChild(text);
    }

    if (isValid) {
        icon.className = 'bi bi-check-lg text-success me-1';  // Green checkmark for valid
        text.className = 'text-success';  // Change text color to green
    } else {
        icon.className = 'bi bi-x-lg text-danger me-1';  // Red cross for invalid
        text.className = 'text-danger';  // Change text color to red
    }
}

// MPIN Generation and Validation Logic
function generateMPIN(event) {
    event.preventDefault();  // Prevent form submission until validation passes

    const mpin = getMPIN("mpin");
    const confirm = getMPIN("cmpin");

    // Clear previous error messages
    document.getElementById("mpin-error-message").textContent = '';
    document.getElementById("cmpin-error-message").textContent = '';

    // Clear previous red border from all input fields
    const mpinInputs = document.querySelectorAll('.mpin-box');
    mpinInputs.forEach(input => {
        input.classList.remove('input-error');
    });

    // Re-run the requirement check before final submission
    updateRequirements();

    // 1. Check if both MPIN and Confirm MPIN are exactly 6 digits
    if (mpin.length !== 6 || confirm.length !== 6) {
        document.getElementById("mpin-error-message").textContent = 'Please enter a complete 6-digit MPIN in both fields.';

        // Add red border to MPIN fields
        mpinInputs.forEach(input => {
            input.classList.add('input-error');
        });

        return;  // Stop execution if the MPIN is not correct
    }

    // 2. Check if MPIN and Confirm MPIN match
    if (mpin !== confirm) {
        document.getElementById("cmpin-error-message").textContent = 'The MPIN and Confirm MPIN do not match!';

        // Add red border to MPIN fields
        mpinInputs.forEach(input => {
            input.classList.add('input-error');
        });

        return;
    }

    // 3. Check for sequential MPIN
    if (isSequential(mpin)) {
        document.getElementById("mpin-error-message").textContent = 'MPIN should not be sequential (e.g., 123456 or 654321).';

        // Add red border to MPIN fields
        mpinInputs.forEach(input => {
            input.classList.add('input-error');
        });

        return;
    }

    // 4. Check for repeated MPIN
    if (isRepeated(mpin)) {
        document.getElementById("mpin-error-message").textContent = 'MPIN should not contain repeated digits (e.g., 111111).';

        // Add red border to MPIN fields
        mpinInputs.forEach(input => {
            input.classList.add('input-error');
        });

        return;
    }

    // If all checks pass, submit the form
    document.getElementById("mpin-form").submit(); // Submit the form programmatically

    // Show success message and redirect after 5 seconds
    Swal.fire({
        icon: 'success',
        title: 'MPIN Generated Successfully!',
        text: 'Your MPIN has been created successfully.',
        confirmButtonColor: '#28a745',
        timer: 5000,  // 5 seconds
        timerProgressBar: true,  // Show progress bar during timer
    }).then(() => {
        // Redirect to dashboard after success
        window.location.href = '/dashboard';  // Replace this with the correct dashboard URL
    });
}

// Auto-Focus/Auto-Tab Logic for input fields
function handleInput(e) {
    const input = e.target;

    // Call the real-time update function only for the main MPIN entry
    if (input.id.startsWith('mpin')) {
        updateRequirements();
    }

    // Auto-focus next input field on successful entry
    if (input.value && input.value.length === input.maxLength) {
        let next = input.nextElementSibling;
        while (next && next.tagName !== 'INPUT') {
            next = next.nextElementSibling;
        }
        if (next) {
            next.focus();
        }
    }

    // Auto-focus previous input field on backspace/delete
    if (e.inputType === 'deleteContentBackward' && input.value.length === 0) {
        let prev = input.previousElementSibling;
        while (prev && prev.tagName !== 'INPUT') {
            prev = prev.previousElementSibling;
        }
        if (prev) {
            prev.focus();
        }
    }
}

// Setup function to attach event listeners
function setupAutoTab() {
    const mpinInputs = document.querySelectorAll('.mpin-box');

    mpinInputs.forEach(input => {
        input.addEventListener('input', handleInput);
    });

    // Initialize the validation icons and text to be red by default
    const initialIcons = document.querySelectorAll('.mpin-req-box li');
    initialIcons.forEach((li) => {
        let icon = li.querySelector('i');
        if (!icon) {
            icon = document.createElement('i');
            li.prepend(icon);
        }
        icon.className = 'bi bi-x-lg text-danger me-1';  // Set all to red initially

        let text = li.querySelector('span');
        if (!text) {
            text = document.createElement('span');
            li.appendChild(text);
        }
        text.className = 'text-danger';  // Set text to red initially
    });

    // Initial check to ensure requirements are visible (all crosses initially)
    updateRequirements();
}

// Adding the red border CSS class to highlight inputs on error
document.addEventListener('DOMContentLoaded', function () {
    setupAutoTab();

    // Attach the event listener to the submit button
    document.getElementById('form-submit').addEventListener('click', generateMPIN);
});
